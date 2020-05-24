<?php
// src\Controller\Backend\UsersController.php
namespace App\Controller\Backend;

use DateTime;
use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UsersController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @IsGranted("ROLE_ADMIN")
 * 
 * @Route("/admin/users")
 */
class UsersController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * Constructor
     *
     * @param UserRepository         $userRepository
     * @param EntityManagerInterface $objectManager
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->manager = $entityManager;
    }

    /**
     * Liste des joueurs
     * 
     * @return Response
     * 
     * @Route("", name="users_list", methods={"GET"})
     */
    public function list(): Response
    {
        $users = $this->userRepository->findAll();
        //dump($users);
        return $this->render('admin/users/list.html.twig', [
            'users' => $users,
            'controller_name' => 'UsersController'
        ]);
    }

    /**
     * Editer un joueur
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response
     * 
     * @Route("/{id}/edit", name="users_user_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user): Response
    {

        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush(); // Mise à jour du joueur en BDD
            $this->addFlash(
                'success',
                'L\'utilisateur a bien été modifié.'
            );
            return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
        }
        
        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'controller_name' => 'UsersController'
        ]);
    }

    
    /**
     * Editer un joueur
     *
     * @param Request $request
     *
     * @return Response
     * 
     * @Route("/new", name="users_user_new", methods={"GET", "POST"})
     */
     public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
     {
        $user = new User();
        dump($user);
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $user->setValided(false);
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                uniqid()
            ));
            $this->manager->persist($user); // On persiste l'objet $user
            $this->manager->flush(); // On enregistre en BDD
            $this->addFlash(
                'success',
                'L\'utilisateur a bien été enregistré.'
            );
            // TODO : Envoi mail : confirmation email
            // TODO : Envoi mail : mot de passe
            return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
        }
         
        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'controller_name' => 'UsersController'
        ]);
     }

    /**
     * Réinitialise le mot de passe d'un joueur
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response
     *
     * @Route("/{id}/password/reset", name="users_user_pass_reset", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function resetPassword(Request $request, User $user): Response
    {
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        dump($user);
        $form = $this->createForm(AdminUserType::class, $user);
        
        return $this->render('admin/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'controller_name' => 'UsersController'
        ]);
        // TODO : Mise à jour du pwd
        // TODO : Mise à jour statut is_valid
        // TODO : Création token validation
        // TODO : Email pour confirmer email
        // TODO : Msg flash pour informer changement pwd
        return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
    }

    /**
     * Suppression d'un joueur
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response
     * 
     * @Route("/{id}/delete", name="users_user_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        if (!$user->getEnabled()) {
            // TODO : Transfert des personnages vers user PNJ
            $this->manager->remove($user); // On retire l'objet $user
            $this->manager->flush(); // On enregistre en BDD
            $this->addFlash(
                'success',
                'L\'utilisateur a bien été supprimé.'
            );
            // TODO : Email pour informer delete joueur
        } else {
            $this->addFlash(
                'danger',
                'L\'utilisateur ne peut pas être supprimé avec un status actif.'
            );
        }
        return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
    }

    /**
     * Demande de validation de l'email un joueur
     * 
     * @param User $user
     *
     * @return Response
     * 
     * @Route("/{id}/valid", name="users_user_valid", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function valided(User $user): Response
    {
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);
        
        $user->setValided(!$user->getValided()); // Mise à jour statut is_valid
        $this->manager->persist($user);
        $this->manager->flush();
        // TODO : Email pour demander confirmation email

        return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
    }

    /**
     * valide ou invalide un joueur
     *
     * @param User $user
     *
     * @return Response
     *
     * @Route("/{id}/enable", name="users_user_enable", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function enabled(User $user): Response
    {
        $user = $this->userRepository->findOneBy(['id' => $user->getId()]);

        $user->setEnabled(!$user->getEnabled()); // Mise à jour statut is_enable
        $this->manager->persist($user);
        $this->manager->flush();
        // TODO : Email pour informer activation ou désactivation du compte
        
        return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
    }
}

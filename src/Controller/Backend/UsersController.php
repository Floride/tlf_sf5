<?php
// src\Controller\Backend\UsersController.php
namespace App\Controller\Backend;

use DateTime;
use App\Controller\AbstractCrudController;
use App\Entity\User;
use App\Form\AdminUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
class UsersController extends AbstractCrudController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $entityManager
     * @param UserRepository         $userRepository
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        parent::__construct($entityManager);
        $this->userRepository = $userRepository;
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
        if ($this->isCsrfTokenValid('users_user_delete_' . $user->getId(), $request->get('_token'))) {
            if (!$user->getEnabled()) {
                // TODO : Transfert des personnages vers user PNJ
                $this->suppression($user);
                $this->messageFlash('delete_ok', 'utilisateur');
            // TODO : Email pour informer delete joueur
            } else {
                $this->messageFlash('status_bad', 'utilisateur');
            }
        } else {
            $this->messageFlash('csrf_bad');
        }

        return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
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
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($user);
            $this->messageFlash('save_ok', 'utilisateur');
            return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
        }
        
        return $this->render('admin/users/edit.html.twig', [
            'controller_name' => 'UsersController',
            'form' => $form->createView(),
            'user' => $user,
        ]);
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
        $user->setEnabled(!$user->getEnabled()); // Mise à jour statut is_enable
        $this->sauvegarde($user);
        // TODO : Email pour informer activation ou désactivation du compte
        
        return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
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
        
        return $this->render('admin/users/list.html.twig', [
            'users' => $users,
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
        $pwd = uniqid();
        $form = $this->createForm(AdminUserType::class, $user);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $user->setValided(false);
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $pwd
            ));
            $this->sauvegarde($user);
            $this->messageFlash('save_ok', 'utilisateur');
            // TODO : Envoi mail : confirmation email
            // TODO : Envoi mail : mot de passe
            return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
        }
         
        return $this->render('admin/users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'controller_name' => 'UsersController'
        ]);
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
        $user->setValided(!$user->getValided()); // Mise à jour statut is_valid
        $this->sauvegarde($user);
        // TODO : Email pour demander confirmation email

        return $this->redirect($this->generateUrl('users_list')); // redirection vers la liste des Joueurs
    }
}

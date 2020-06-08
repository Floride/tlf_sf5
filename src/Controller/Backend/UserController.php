<?php
// src\Controller\Backend\UserController.php
namespace App\Controller\Backend;

use App\Entity\User;
use DateTimeImmutable;
use App\Form\Admin\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * CRUD for User class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/user",
 *      name="admin_user_"
 * )
 */
class UserController extends AbstractCrudController
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
     * banni ?
     *
     * @param User $user
     *
     * @return Response
     *
     * @Route("/{id}/banned",
     *      name="banned", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function banned(User $user): Response
    {
        $beforeBan = $user; 
        // TODO : Email pour informer bannissement du compte
        $user->setBanned(!$user->getBanned()); // Mise à jour statut is_Banned
        $this->save($user);

        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * Suppression d'un joueur
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response
     *
     * @Route("/{id}/delete",
     *      name="delete",
     *      requirements={"id"="\d+"},
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('admin_user_delete_' . $user->getId(), $request->get('_token'))) {
            if (!$user->getEnable() && !$user->getBan()) {
                // TODO : Transfert des personnages vers user PNJ
                $this->suppression($user);
                $this->sendFlashMessage('delete_ok', 'utilisateur');
                // TODO : Email pour informer delete joueur
            } elseif ($user->getBan()) {
                $this->sendFlashMessage('ban_bad', 'utilisateur');
            } else {
                $this->sendFlashMessage('active_bad', 'utilisateur');
            }
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * Editer un joueur
     *
     * @param Request $request
     * @param User $user
     *
     * @return Response
     *
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($user);
            $this->sendFlashMessage('save_ok', 'utilisateur');
            
            return $this->redirectToRoute('admin_user_list');
        }
        
        return $this->render('admin/user/edit.html.twig', [
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
     * @Route("/{id}/enable",
     *      name="enable",
     *      requirements={"id"="\d+"},
     *      methods={"GET"}
     * )
     */
    public function enable(User $user): Response
    {
        $user->setEnable(!$user->getEnable()); // Mise à jour statut is_enable
        $this->save($user);
        // TODO : Email pour informer activation ou désactivation du compt
            
        return $this->redirectToRoute('admin_user_list');
    }

    /**
     * List
     *
     * @param PaginatorInterface $paginator
     * @param Request $request
     * 
     * @return Response
     *
     * @Route("", 
     *      name="list",
     *      methods={"GET"}
     * )
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        $users = $paginator->paginate(
            $this->userRepository->findByEmailQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            10                                  // Limite par page
        );

        return $this->render('admin/user/list.html.twig', [
            'users' => $users,
        ]);
    }
    
    /**
     * Editer un joueur
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/new",
     *      name="new",
     *      methods={"GET", "POST"}
     * )
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $pwd = uniqid();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
 
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setEnabled(true);
            $user->setValided(false);
            $user->setPassword($passwordEncoder->encodePassword(
                $user,
                $pwd
            ));
            $this->save($user);
            $this->sendFlashMessage('save_ok', 'utilisateur');
            // TODO : Envoi mail : confirmation email
            // TODO : Envoi mail : mot de passe

            return $this->redirectToRoute('admin_user_list');
        }
         
        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Demande de validation de l'email un joueur
     *
     * @param User $user
     *
     * @return Response
     *
     * @Route("/{id}/valid",
     *      name="valid",
     *      requirements={"id"="\d+"},
     *      methods={"GET"}
     * )
     */
    public function valided(User $user): Response
    {
        $user->setValided(!$user->getValided()); // Mise à jour statut is_valid
        $this->save($user);
        // TODO : Email pour demander confirmation email

        return $this->redirectToRoute('admin_user_list');
    }
}

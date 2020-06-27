<?php
// src\Controller\Backend\Character\RoleController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Role;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Admin\Character\RoleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Character\RoleRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class RoleController
 * CRUD for Role class
 * 
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/role",
 *      name="admin_character_role_"
 * )
 */
class RoleController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_role_list';

    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * RoleController Constructor
     *
     * @param RoleRepository   $roleRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(RoleRepository $roleRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->roleRepository = $roleRepository;
    }

    /**
     * Default
     *
     * @param Request $request
     * @param Role    $role
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/default", 
     *      name="default", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function default(Request $request, Role $role): RedirectResponse
    {
        $role->setDefault(!$role->getDefault()); // Mise à jour statut is_default
        $this->save($role);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Delete
     *
     * @param Request    $request
     * @param Role $role
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Role $role): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_character_role_delete_' . $role->getId(), $request->get('_token'))) {
            $this->suppression($role);
            $this->sendFlashMessage('delete_ok', 'fonction', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
    /**
     * Edit
     *
     * @param Request    $request
     * @param Role $role
     *
     * @return RedirectResponse|Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Role $role)
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($role);
            $this->sendFlashMessage('save_ok', 'fonction', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/role/edit.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * List
     * 
     * @param PaginatorInterface $paginator
     * @param Request            $request
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
        $display = $request->get('display', 'list');
        $roles = $paginator->paginate(
            $this->roleRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/character/role/list.html.twig', [
            'display' => $display,
            'roles' => $roles,
        ]);
    }

    /**
     * New
     * 
     * @param Request $request
     * 
     * @return RedirectResponse|Response
     * 
     * @Route("/new", 
     *      name="new", 
     *      methods={"GET", "POST"}
     * )
     */
    public function new(Request $request)
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($role);
            $this->sendFlashMessage('save_ok', 'fonction', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/role/new.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Playable
     *
     * @param Request    $request
     * @param Role $role
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/playable", 
     *      name="playable", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function playable(Request $request, Role $role): RedirectResponse
    {
        $role->setPlayable(!$role->getPlayable()); // Mise à jour statut is_playable
        $this->save($role);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }

    /**
     * Obsolete
     *
     * @param Request    $request
     * @param Role $role
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, Role $role): RedirectResponse
    {
        $role->setObsolete(!$role->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($role);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
}

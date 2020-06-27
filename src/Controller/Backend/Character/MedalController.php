<?php
// src\Controller\Backend\Character\MedalController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Medal;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Admin\Character\MedalType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Character\MedalRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class MedalController
 * CRUD for Medal class
 * 
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/medal",
 *      name="admin_character_medal_"
 * )
 */
class MedalController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_medal_list';

    /**
     * @var MedalRepository
     */
    private $medalRepository;

    /**
     * MedalController Constructor
     *
     * @param MedalRepository   $medalRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(MedalRepository $medalRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->medalRepository = $medalRepository;
    }

    /**
     * Delete
     *
     * @param Request $request
     * @param Medal   $medal
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Medal $medal): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_character_medal_delete_' . $medal->getId(), $request->get('_token'))) {
            $this->suppression($medal);
            $this->sendFlashMessage('delete_ok', 'accréditation', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
    /**
     * Edit
     *
     * @param Request $request
     * @param Medal   $medal
     *
     * @return RedirectResponse|Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Medal $medal)
    {
        $form = $this->createForm(MedalType::class, $medal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($medal);
            $this->sendFlashMessage('save_ok', 'accréditation', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/medal/edit.html.twig', [
            'medal' => $medal,
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
        $medals = $paginator->paginate(
            $this->medalRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/character/medal/list.html.twig', [
            'display' => $display,
            'medals' => $medals,
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
        $medal = new Medal();
        $form = $this->createForm(MedalType::class, $medal);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($medal);
            $this->sendFlashMessage('save_ok', 'accréditation', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/medal/new.html.twig', [
            'medal' => $medal,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Playable
     *
     * @param Request $request
     * @param Medal   $medal
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, Medal $medal): RedirectResponse
    {
        $medal->setObsolete(!$medal->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($medal);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
}

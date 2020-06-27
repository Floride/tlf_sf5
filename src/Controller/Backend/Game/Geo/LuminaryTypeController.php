<?php
// src\Controller\Backend\Game\Geo\LuminaryTypeController.php
namespace App\Controller\Backend\Game\Geo;

use App\Entity\Game\Geo\LuminaryType;
use App\Form\Admin\Game\Geo\LuminaryTypeType as L_Type;
use App\Repository\Game\Geo\LuminaryTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class LuminaryTypeController
 * CRUD for LuminaryType class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/game/geo/luminaryType", 
 *      name="admin_game_geo_luminaryType_"
 * )
 */
class LuminaryTypeController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_game_geo_luminaryType_list';

    /**
     * @var LuminaryTypeRepository
     */
    private $luminaryTypeRepository;

    /**
     * Constructor
     *
     * @param LuminaryTypeRepository     $luminaryTypeRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, LuminaryTypeRepository $luminaryTypeRepository)
    {
        parent::__construct($entityManager);
        $this->luminaryTypeRepository = $luminaryTypeRepository;

    }

    /**
     * Delete
     *
     * @param LuminaryType $luminaryType
     * @param Request  $request
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, LuminaryType $luminaryType): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_game_geo_luminaryType_delete_' . $luminaryType->getId(), $request->get('_token'))) {
            $this->suppression($luminaryType);
            $this->sendFlashMessage('delete_ok', 'type d\'astre');
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Edit
     *
     * @param LuminaryType $luminaryType
     * @param Request  $request
     *
     * @return RedirectResponse|Response
     * 
     * @Route("{id}/edit", 
     *      name="edit", 
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, LuminaryType $luminaryType)
    {
        $form = $this->createForm(L_Type::class, $luminaryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($luminaryType);
            $this->sendFlashMessage('save_ok', 'type d\'astre');

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/luminaryType/edit.html.twig', [
            'form' => $form->createView(),
            'luminaryType' => $luminaryType,
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
        $luminaries = $paginator->paginate(
            $this->luminaryTypeRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/game/geo/luminaryType/list.html.twig', [
            'luminaries' => $luminaries,
        ]);
    }
    
    /**
     * New
     *
     * @param LuminaryType $luminaryType
     * @param Request  $request
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
        $luminaryType = new LuminaryType();
        
        $form = $this->createForm(L_Type::class, $luminaryType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($luminaryType);
            $this->sendFlashMessage('save_ok', 'type d\'astre');
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/luminaryType/new.html.twig', [
            'form' => $form->createView(),
            'luminaryType' => $luminaryType,
        ]);
    }

    /**
     * Obsolete
     *
     * @param Request    $request
     * @param LuminaryType $luminaryType
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, LuminaryType $luminaryType): RedirectResponse
    {
        $luminaryType->setObsolete(!$luminaryType->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($luminaryType);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
}

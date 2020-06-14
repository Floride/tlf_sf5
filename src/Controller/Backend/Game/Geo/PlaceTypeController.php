<?php
// src\Controller\Backend\Game\Geo\PlaceTypeController.php
namespace App\Controller\Backend\Game\Geo;

use App\Entity\Game\Geo\PlaceType;
use App\Form\Admin\Game\Geo\PlaceTypeType as P_Type;
use App\Repository\Game\Geo\PlaceTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class PlaceTypeController
 * CRUD for PlaceType class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/game/geo/placeType", 
 *      name="admin_game_geo_placeType_"
 * )
 */
class PlaceTypeController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_game_geo_placeType_list';

    /**
     * @var PlaceTypeRepository
     */
    private $placeTypeRepository;

    /**
     * Constructor
     *
     * @param PlaceTypeRepository        $placeTypeRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, PlaceTypeRepository $placeTypeRepository)
    {
        parent::__construct($entityManager);
        $this->placeTypeRepository = $placeTypeRepository;

    }

    /**
     * Delete
     *
     * @param PlaceType   $placeType
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, PlaceType $placeType): Response
    {
        if ($this->isCsrfTokenValid('admin_game_geo_placeType_delete_' . $placeType->getId(), $request->get('_token'))) {
            $this->suppression($placeType);
            $this->sendFlashMessage('delete_ok', 'type de lieu');
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Edit
     *
     * @param PlaceType   $placeType
     * @param Request $request
     *
     * @return Response
     * 
     * @Route("{id}/edit", 
     *      name="edit", 
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, PlaceType $placeType): Response
    {
        $form = $this->createForm(P_Type::class, $placeType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($placeType);
            $this->sendFlashMessage('save_ok', 'type de lieu');

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/placeType/edit.html.twig', [
            'form' => $form->createView(),
            'placeType' => $placeType,
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
        $placeTypes = $paginator->paginate(
            $this->placeTypeRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/game/geo/placeType/list.html.twig', [
            'placeTypes' => $placeTypes,
        ]);
    }
    
    /**
     * New
     *
     * @param PlaceType   $placeType
     * @param Request $request
     *
     * @return Response
     * 
     * @Route("/new", 
     *      name="new", 
     *      methods={"GET", "POST"}
     * )
     */
    public function new(Request $request): Response
    {
        $placeType = new PlaceType();
        
        $form = $this->createForm(P_Type::class, $placeType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($placeType);
            $this->sendFlashMessage('save_ok', 'type de lieu');
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/placeType/new.html.twig', [
            'form' => $form->createView(),
            'placeType' => $placeType,
        ]);
    }

    /**
     * Obsolete
     *
     * @param PlaceType   $placeType
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, PlaceType $placeType): Response
    {
        $placeType->setObsolete(!$placeType->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($placeType);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
}

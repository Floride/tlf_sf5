<?php
// src\Controller\Backend\Game\Geo\PlaceController.php
namespace App\Controller\Backend\Game\Geo;

use App\Entity\Game\Geo\Place;
use App\Form\Admin\Game\Geo\PlaceType;
use App\Repository\Game\Geo\PlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class PlaceController
 * CRUD for Place class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/game/geo/place", 
 *      name="admin_game_geo_place_"
 * )
 */
class PlaceController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_game_geo_place_list';

    /**
     * @var PlaceRepository
     */
    private $placeRepository;

    /**
     * Constructor
     *
     * @param PlaceRepository        $placeRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, PlaceRepository $placeRepository)
    {
        parent::__construct($entityManager);
        $this->placeRepository = $placeRepository;

    }

    /**
     * Delete
     *
     * @param Place   $place
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Place $place): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_game_geo_place_delete_' . $place->getId(), $request->get('_token'))) {
            $this->suppression($place);
            $this->sendFlashMessage('delete_ok', 'lieu');
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Edit
     *
     * @param Place   $place
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * 
     * @Route("{id}/edit", 
     *      name="edit", 
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Place $place)
    {
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($place);
            $this->sendFlashMessage('save_ok', 'lieu');

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/place/edit.html.twig', [
            'form' => $form->createView(),
            'place' => $place,
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
        $places = $paginator->paginate(
            $this->placeRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/game/geo/place/list.html.twig', [
            'places' => $places,
        ]);
    }
    
    /**
     * New
     *
     * @param Place   $place
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
        $place = new Place();
        
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($place);
            $this->sendFlashMessage('save_ok', 'lieu');
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/place/new.html.twig', [
            'form' => $form->createView(),
            'place' => $place,
        ]);
    }

    /**
     * Obsolete
     *
     * @param Place   $place
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, Place $place): RedirectResponse
    {
        $place->setObsolete(!$place->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($place);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
}

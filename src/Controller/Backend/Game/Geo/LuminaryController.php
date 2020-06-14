<?php
// src\Controller\Backend\Game\Geo\LuminaryController.php
namespace App\Controller\Backend\Game\Geo;

use App\Entity\Game\Geo\Luminary;
use App\Form\Admin\Game\Geo\LuminaryType;
use App\Repository\Game\Geo\LuminaryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class LuminaryController
 * CRUD for Luminary class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/game/geo/luminary", 
 *      name="admin_game_geo_luminary_"
 * )
 */
class LuminaryController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_game_geo_luminary_list';

    /**
     * @var LuminaryRepository
     */
    private $luminaryRepository;

    /**
     * Constructor
     *
     * @param LuminaryRepository     $luminaryRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, LuminaryRepository $luminaryRepository)
    {
        parent::__construct($entityManager);
        $this->luminaryRepository = $luminaryRepository;

    }

    /**
     * Delete
     *
     * @param Luminary $luminary
     * @param Request  $request
     *
     * @return Response
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Luminary $luminary): Response
    {
        if ($this->isCsrfTokenValid('admin_game_geo_luminary_delete_' . $luminary->getId(), $request->get('_token'))) {
            $this->suppression($luminary);
            $this->sendFlashMessage('delete_ok', 'astre');
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Edit
     *
     * @param Luminary $luminary
     * @param Request  $request
     *
     * @return Response
     * 
     * @Route("{id}/edit", 
     *      name="edit", 
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Luminary $luminary): Response
    {
        $form = $this->createForm(LuminaryType::class, $luminary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($luminary);
            $this->sendFlashMessage('save_ok', 'astre');

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/luminary/edit.html.twig', [
            'form' => $form->createView(),
            'luminary' => $luminary,
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
            $this->luminaryRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/game/geo/luminary/list.html.twig', [
            'luminaries' => $luminaries,
        ]);
    }
    
    /**
     * New
     *
     * @param Luminary $luminary
     * @param Request  $request
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
        $luminary = new Luminary();
        
        $form = $this->createForm(LuminaryType::class, $luminary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($luminary);
            $this->sendFlashMessage('save_ok', 'astre');
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/geo/luminary/new.html.twig', [
            'form' => $form->createView(),
            'luminary' => $luminary,
        ]);
    }

    /**
     * Obsolete
     *
     * @param Request    $request
     * @param Luminary $luminary
     *
     * @return Response
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, Luminary $luminary): Response
    {
        $luminary->setObsolete(!$luminary->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($luminary);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
}

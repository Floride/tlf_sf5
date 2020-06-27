<?php
// src\Controller\Backend\Character\FeatureController.php
namespace App\Controller\Backend\Character;

use App\Controller\AbstractCrudController;
use App\Entity\Character\Feature;
use App\Form\Admin\Character\FeatureType;
use App\Repository\Character\FeatureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FeatureController
 * CRUD for Feature class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/feature",
 *      name="admin_character_feature_"
 * )
 */
class FeatureController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_feature_list';
    
    /**
     * @var FeatureRepository
     */
    private $featureRepository;

    /**
     * FeatureController Constructor
     *
     * @param FeatureRepository      $featureRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(FeatureRepository $featureRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->featureRepository = $featureRepository;
    }

    /**
     * Delete
     * 
     * @param Request $request
     * @param Feature $feature
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Feature $feature): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_character_feature_delete_' . $feature->getId(), $request->get('_token'))) {
            $this->suppression($feature);
            $this->sendFlashMessage('delete_ok', 'caractéristique', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }
    
    /**
     * Edit
     *
     * @param Request $request
     * @param Feature $feature
     *
     * @return RedirectResponse|Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Feature $feature)
    {
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($feature);
            $this->sendFlashMessage('save_ok', 'caractéristique', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/feature/edit.html.twig', [
            'feature' => $feature,
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
        $display = $request->get('display', 'card');
        $features = $paginator->paginate(
            $this->featureRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'card') ? 12 : 25   // Limite par page
        );

        return $this->render('admin/character/feature/list.html.twig', [
            'display' => $display,
            'features' => $features,
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
        $feature = new Feature();
        $form = $this->createForm(FeatureType::class, $feature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($feature);
            $this->sendFlashMessage('save_ok', 'caractéristique', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/feature/new.html.twig', [
            'feature' => $feature,
            'form' => $form->createView(),
        ]);
    }
}

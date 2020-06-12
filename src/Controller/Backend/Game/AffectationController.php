<?php
// src\Controller\Backend\Game\AffectationController.php
namespace App\Controller\Backend\Game;

use DateTimeImmutable;
use App\Entity\Game\Affectation;
use App\Form\Admin\Game\AffectationType;
use App\Repository\Game\AffectationRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class AffectationController
 * CRUD for Affectation class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/game/affectation", 
 *      name="admin_game_affectation_"
 * )
 */
class AffectationController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_game_affectation_list';

    /**
     * @var AffectationRepository
     */
    private $affectationRepository;

    /**
     * Constructor
     *
     * @param AffectationRepository  $affectationRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, AffectationRepository $affectationRepository)
    {
        parent::__construct($entityManager);
        $this->affectationRepository = $affectationRepository;

    }

    /**
     * Default
     *
     * @param Request     $request
     * @param Affectation $affectation
     *
     * @return Response
     *
     * @Route("/{id}/default", 
     *      name="default", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function default(Request $request, Affectation $affectation): Response
    {
        $affects = $this->affectationRepository->findAll();
        foreach ($affects as $affect) {
            if ($affect != $affectation) {
                $affect->setDefault(false);
                $this->manager->persist($affect);
            }
        }
        $this->manager->flush();

        $affectation->setDefault(!$affectation->getDefault()); // Mise à jour statut is_default
        $this->save($affectation);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Delete
     *
     * @param Affectation     $affectation
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
    public function delete(Request $request, Affectation $affectation): Response
    {
        if ($this->isCsrfTokenValid('admin_game_affectation_delete_' . $affectation->getId(), $request->get('_token'))) {
            $this->suppression($affectation);
            $this->sendFlashMessage('delete_ok', 'affectation', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Edit
     *
     * @param Affectation     $affectation
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
    public function edit(Request $request, Affectation $affectation): Response
    {
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($affectation);
            $this->sendFlashMessage('save_ok', 'affectation', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/affectation/edit.html.twig', [
            'form' => $form->createView(),
            'affectation' => $affectation,
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
    public function list(Request $request): Response
    {
        $affectations = $this->affectationRepository->findAll();
        $affectations = $this->getStairDisplay($affectations);

        return $this->render('admin/game/affectation/list.html.twig', [
            'affectations' => $affectations,
        ]);
    }
    
    /**
     * New
     *
     * @param Affectation     $affectation
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
        $affectation = new Affectation();
        
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($affectation);
            $this->sendFlashMessage('save_ok', 'affectation', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/game/affectation/new.html.twig', [
            'form' => $form->createView(),
            'affectation' => $affectation,
        ]);
    }

    /**
     * Obsolete
     *
     * @param Request    $request
     * @param Affectation $affectation
     *
     * @return Response
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, Affectation $affectation): Response
    {
        $affectation->setObsolete(!$affectation->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($affectation);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }

    /**
     * getStairDisplay
     *
     * @param Affectation[] $affectations
     * @return array
     */
    private function getStairDisplay(array $affectations): array
    {
        $usedId = [];
        foreach ($affectations as $affectation) {
            // Level 0
            $id = $affectation->getId();
            if (!in_array($id, $usedId)) {
                $usedId[] = $id;
                $result[] = ['data' => $affectation, 'lvl' => 0];
            }
            foreach ($affectation->getChilds() as $child_1) {
                // Level 1
                $id = $child_1->getId();
                if (!in_array($id, $usedId)) {
                    $usedId[] = $id;
                    $result[] = ['data' => $child_1, 'lvl' => 1];
                }
                foreach ($child_1->getChilds() as $child_2) {
                    // Level 2
                    $id = $child_2->getId();
                    if (!in_array($id, $usedId)) {
                        $usedId[] = $id;
                        $result[] = ['data' => $child_2, 'lvl' => 2];
                    }
                    foreach ($child_2->getChilds() as $child_3) {
                        // Level 3
                        $id = $child_3->getId();
                        if (!in_array($id, $usedId)) {
                            $usedId[] = $id;
                            $result[] = ['data' => $child_3, 'lvl' => 3];
                        }
                        foreach ($child_3->getChilds() as $child_4) {
                            // Level 4
                            $id = $child_4->getId();
                            if (!in_array($id, $usedId)) {
                                $usedId[] = $id;
                                $result[] = ['data' => $child_4, 'lvl' => 4];
                            }
                            foreach ($child_4->getChilds() as $child_5) {
                                // Level 5
                                $id = $child_5->getId();
                                if (!in_array($id, $usedId)) {
                                    $usedId[] = $id;
                                    $result[] = ['data' => $child_5, 'lvl' => 5];
                                }
                                foreach ($child_5->getChilds() as $child_6) {
                                    // Level 6
                                    $id = $child_6->getId();
                                    if (!in_array($id, $usedId)) {
                                        $usedId[] = $id;
                                        $result[] = ['data' => $child_6, 'lvl' => 6];
                                    }
                                    foreach ($child_6->getChilds() as $child_7) {
                                        // Level 7
                                        $id = $child_7->getId();
                                        if (!in_array($id, $usedId)) {
                                            $usedId[] = $id;
                                            $result[] = ['data' => $child_7, 'lvl' => 7];
                                        }
                                        foreach ($child_7->getChilds() as $child_8) {
                                            // Level 8
                                            $id = $child_8->getId();
                                            if (!in_array($id, $usedId)) {
                                                $usedId[] = $id;
                                                $result[] = ['data' => $child_8, 'lvl' => 8];
                                            }
                                            foreach ($child_8->getChilds() as $child_9) {
                                                // Level 9
                                                $id = $child_9->getId();
                                                if (!in_array($id, $usedId)) {
                                                    $usedId[] = $id;
                                                    $result[] = ['data' => $child_9, 'lvl' => 9];
                                                }
                                                foreach ($child_9->getChilds() as $child_10) {
                                                    // Level 10
                                                    $id = $child_10->getId();
                                                    if (!in_array($id, $usedId)) {
                                                        $usedId[] = $id;
                                                        $result[] = ['data' => $child_10, 'lvl' => 10];
                                                    }
                                                    foreach ($child_10->getChilds() as $child_11) {
                                                        // Level 11
                                                        $id = $child_11->getId();
                                                        if (!in_array($id, $usedId)) {
                                                            $usedId[] = $id;
                                                            $result[] = ['data' => $child_11, 'lvl' => 11];
                                                        }
                                                        foreach ($child_11->getChilds() as $child_12) {
                                                            // Level 12
                                                            $id = $child_12->getId();
                                                            if (!in_array($id, $usedId)) {
                                                                $usedId[] = $id;
                                                                $result[] = ['data' => $child_12, 'lvl' => 12];
                                                            }
                                                            foreach ($child_12->getChilds() as $child_13) {
                                                                // Level 13
                                                                $id = $child_13->getId();
                                                                if (!in_array($id, $usedId)) {
                                                                    $usedId[] = $id;
                                                                    $result[] = ['data' => $child_13, 'lvl' => 13];
                                                                }
                                                                foreach ($child_13->getChilds() as $child_14) {
                                                                    // Level 14
                                                                    $id = $child_14->getId();
                                                                    if (!in_array($id, $usedId)) {
                                                                        $usedId[] = $id;
                                                                        $result[] = ['data' => $child_14, 'lvl' => 14];
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $result;
    }
}

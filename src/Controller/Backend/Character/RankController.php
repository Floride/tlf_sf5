<?php
// src\Controller\Backend\Character\RankController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Rank;
use App\Form\Admin\Character\RankType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\Character\RankRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class RankController
 * CRUD for Rank class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/Rank",
 *      name="admin_character_rank_"
 * )
 */
class RankController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_rank_list';

    /**
     * @var RankRepository
     */
    private $rankRepository;

    /**
     * RankController Constructor
     *
     * @param RankRepository        $rankRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(RankRepository $rankRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->rankRepository = $rankRepository;
    }

    /**
     * Delete
     *
     * @param Request $request
     * @param Rank   $rank
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete",
     *      name="delete",
     *      requirements={"id"="\d+"},
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Rank $rank): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_character_rank_delete_' . $rank->getId(), $request->get('_token'))) {
            $this->suppression($rank);
            $this->sendFlashMessage('delete_ok', 'grade');
        } else {
            $this->sendFlashMessage('csrf_bad');
        }
        
        return $this->redirectToRoute(self::RETURN_ROUTE);
    }
    
    /**
     * Edit
     *
     * @param Request $request
     * @param Rank   $rank
     *
     * @return RedirectResponse|Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Rank $rank)
    {
        $form = $this->createForm(RankType::class, $rank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($rank);
            $this->sendFlashMessage('save_ok', 'grade');
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/rank/edit.html.twig', [
            'rank' => $rank,
            'form' => $form->createView(),
        ]);
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
        $display = $request->get('display', 'list');
        $ranks = $paginator->paginate(
            $this->rankRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12    // Limite par page
        );
        return $this->render('admin/character/rank/list.html.twig', [
            'display' => $display,
            'ranks' => $ranks,
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
        $rank = new Rank();
        $form = $this->createForm(RankType::class, $rank);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($rank);
            $this->sendFlashMessage('save_ok', 'garde');

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/rank/new.html.twig', [
            'rank' => $rank,
            'form' => $form->createView(),
        ]);
    }
}

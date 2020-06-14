<?php
// src\Controller\Backend\Character\ProfessionController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Profession;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Admin\Character\ProfessionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Character\ProfessionRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ProfessionController
 * CRUD for Profession class
 * 
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/profession",
 *      name="admin_character_profession_"
 * )
 */
class ProfessionController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_profession_list';

    /**
     * @var ProfessionRepository
     */
    private $professionRepository;

    /**
     * ProfessionController Constructor
     *
     * @param ProfessionRepository   $professionRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ProfessionRepository $professionRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->professionRepository = $professionRepository;
    }

    /**
     * Delete
     *
     * @param Request    $request
     * @param Profession $profession
     *
     * @return Response
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Profession $profession): Response
    {
        if ($this->isCsrfTokenValid('admin_character_profession_delete_' . $profession->getId(), $request->get('_token'))) {
            $this->suppression($profession);
            $this->sendFlashMessage('delete_ok', 'profession', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
    /**
     * Edit
     *
     * @param Request    $request
     * @param Profession $profession
     *
     * @return Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Profession $profession): Response
    {
        $form = $this->createForm(ProfessionType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($profession);
            $this->sendFlashMessage('save_ok', 'profession', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/profession/edit.html.twig', [
            'profession' => $profession,
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
        $professions = $paginator->paginate(
            $this->professionRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/character/profession/list.html.twig', [
            'display' => $display,
            'professions' => $professions,
        ]);
    }

    /**
     * New
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
    public function new(Request $request): Response
    {
        $profession = new Profession();
        $form = $this->createForm(ProfessionType::class, $profession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($profession);
            $this->sendFlashMessage('save_ok', 'profession', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/profession/new.html.twig', [
            'profession' => $profession,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Playable
     *
     * @param Request    $request
     * @param Profession $profession
     *
     * @return Response
     *
     * @Route("/{id}/playable", 
     *      name="playable", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function playable(Request $request, Profession $profession): Response
    {
        $profession->setPlayable(!$profession->getPlayable()); // Mise à jour statut is_playable
        $this->save($profession);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }

    /**
     * Obsolete
     *
     * @param Request    $request
     * @param Profession $profession
     *
     * @return Response
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, Profession $profession): Response
    {
        $profession->setObsolete(!$profession->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($profession);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
}

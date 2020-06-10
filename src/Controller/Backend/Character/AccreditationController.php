<?php
// src\Controller\Backend\Character\AccreditationController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Accreditation;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Admin\Character\AccreditationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Character\AccreditationRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class AccreditationController
 * CRUD for Accreditation class
 * 
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/accreditation",
 *      name="admin_character_accreditation_"
 * )
 */
class AccreditationController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_accreditation_list';

    /**
     * @var AccreditationRepository
     */
    private $accreditationRepository;

    /**
     * AccreditationController Constructor
     *
     * @param AccreditationRepository   $accreditationRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(AccreditationRepository $accreditationRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->accreditationRepository = $accreditationRepository;
    }

    /**
     * Default
     *
     * @param Request    $request
     * @param Accreditation $accreditation
     *
     * @return Response
     *
     * @Route("/{id}/default", 
     *      name="default", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function default(Request $request, Accreditation $accreditation): Response
    {
        // Toutes les accreditations = false
        $accreds = $this->accreditationRepository->findAll();
        foreach ($accreds as $accred) {
            if ($accred != $accreditation) {
                $accred->setDefault(false);
                $this->manager->persist($accred);
            }
        }
        $this->manager->flush();

        $accreditation->setDefault(!$accreditation->getDefault()); // Mise à jour statut is_default
        $this->save($accreditation);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Delete
     *
     * @param Request    $request
     * @param Accreditation $accreditation
     *
     * @return Response
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Accreditation $accreditation): Response
    {
        if ($this->isCsrfTokenValid('admin_character_accreditation_delete_' . $accreditation->getId(), $request->get('_token'))) {
            $this->suppression($accreditation);
            $this->sendFlashMessage('delete_ok', 'accréditation', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
    /**
     * Edit
     *
     * @param Request    $request
     * @param Accreditation $accreditation
     *
     * @return Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Accreditation $accreditation): Response
    {
        $form = $this->createForm(AccreditationType::class, $accreditation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($accreditation);
            $this->sendFlashMessage('save_ok', 'accréditation', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/accreditation/edit.html.twig', [
            'accreditation' => $accreditation,
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
        $accreditations = $paginator->paginate(
            $this->accreditationRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/character/accreditation/list.html.twig', [
            'display' => $display,
            'accreditations' => $accreditations,
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
        $accreditation = new Accreditation();
        dump($accreditation);
        $form = $this->createForm(AccreditationType::class, $accreditation);
        $form->handleRequest($request);
        dump($accreditation);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($accreditation);
            $this->sendFlashMessage('save_ok', 'accréditation', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/accreditation/new.html.twig', [
            'accreditation' => $accreditation,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Playable
     *
     * @param Request    $request
     * @param Accreditation $accreditation
     *
     * @return Response
     *
     * @Route("/{id}/playable", 
     *      name="playable", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function playable(Request $request, Accreditation $accreditation): Response
    {
        $accreditation->setPlayable(!$accreditation->getPlayable()); // Mise à jour statut is_playable
        $this->save($accreditation);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
}

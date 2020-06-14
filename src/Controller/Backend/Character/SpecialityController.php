<?php
// src\Controller\Backend\Character\SpecialityController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Speciality;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Admin\Character\SpecialityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Character\SpecialityRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class SpecialityController
 * CRUD for Speciality class
 * 
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/speciality",
 *      name="admin_character_speciality_"
 * )
 */
class SpecialityController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_speciality_list';

    /**
     * @var SpecialityRepository
     */
    private $specialityRepository;

    /**
     * SpecialityController Constructor
     *
     * @param SpecialityRepository   $specialityRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(SpecialityRepository $specialityRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->specialityRepository = $specialityRepository;
    }

    /**
     * Default
     *
     * @param Request    $request
     * @param Speciality $speciality
     *
     * @return Response
     *
     * @Route("/{id}/default", 
     *      name="default", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function default(Request $request, Speciality $speciality): Response
    {
        $specs = $this->specialityRepository->findBy(['profession' => $speciality->getProfession()]);
        foreach ($specs as $spec) {
            if ($spec != $speciality) {
                $spec->setDefault(false);
                $this->manager->persist($spec);
            }
        }
        $this->manager->flush();

        $speciality->setDefault(!$speciality->getDefault()); // Mise à jour statut is_default
        $this->save($speciality);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Delete
     *
     * @param Request    $request
     * @param Speciality $speciality
     *
     * @return Response
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Speciality $speciality): Response
    {
        if ($this->isCsrfTokenValid('admin_character_speciality_delete_' . $speciality->getId(), $request->get('_token'))) {
            $this->suppression($speciality);
            $this->sendFlashMessage('delete_ok', 'speciality', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
    /**
     * Edit
     *
     * @param Request    $request
     * @param Speciality $speciality
     *
     * @return Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Speciality $speciality): Response
    {
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($speciality);
            $this->sendFlashMessage('save_ok', 'speciality', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/speciality/edit.html.twig', [
            'speciality' => $speciality,
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
        $specialities = $paginator->paginate(
            $this->specialityRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/character/speciality/list.html.twig', [
            'display' => $display,
            'specialities' => $specialities,
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
        $speciality = new Speciality();
        $form = $this->createForm(SpecialityType::class, $speciality);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($speciality);
            $this->sendFlashMessage('save_ok', 'speciality', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/speciality/new.html.twig', [
            'speciality' => $speciality,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Playable
     *
     * @param Request    $request
     * @param Speciality $speciality
     *
     * @return Response
     *
     * @Route("/{id}/playable", 
     *      name="playable", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function playable(Request $request, Speciality $speciality): Response
    {
        $speciality->setPlayable(!$speciality->getPlayable()); // Mise à jour statut is_playable
        $this->save($speciality);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }

    /**
     * Obsolete
     *
     * @param Request    $request
     * @param Speciality $speciality
     *
     * @return Response
     *
     * @Route("/{id}/obsolete", 
     *      name="obsolete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function obsolete(Request $request, Speciality $speciality): Response
    {
        $speciality->setObsolete(!$speciality->getObsolete()); // Mise à jour statut is_obsolete
        $this->save($speciality);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
}

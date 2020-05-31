<?php
// src\Controller\Backend\UsersController.php
namespace App\Controller\Backend;

use App\Controller\AbstractCrudController;
use App\Entity\Caracs;
use App\Form\PersoCaracType;
use App\Repository\CaracsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class UsersController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/perso/caracteristiques")
 */
class PersoCaracsController extends AbstractCrudController
{
    /**
     * @var CaracsRepository
     */
    private $caracsRepository;

    /**
     * Constructor
     *
     * @param CaracsRepository       $caracsRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CaracsRepository $caracsRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->caracsRepository = $caracsRepository;
    }

    /**
     * Suppression d'une caractéristique
     *
     * @param Request $request
     * @param Caracs  $carac
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="perso_caracs_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Request $request, Caracs $carac): Response
    {
        if ($this->isCsrfTokenValid('perso_caracs_delete_' . $carac->getId(), $request->get('_token'))) {
            $this->suppression($carac);
            $this->messageFlash('delete_ok', 'caractéristique', false);
        } else {
            $this->messageFlash('csrf_bad');
        }

        return $this->redirect($this->generateUrl('perso_caracs_list')); // redirection vers la liste des caractéristiques
    }
    
    /**
     * Editer une caractéristique
     *
     * @param Request $request
     * @param Caracs  $carac
     *
     * @return Response
     * 
     * @Route("/{id}/edit", name="perso_caracs_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function edit(Request $request, Caracs $carac): Response
    {
        $form = $this->createForm(PersoCaracType::class, $carac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($carac);
            $this->messageFlash('save_ok', 'caractéristique', false);
            return $this->redirect($this->generateUrl('perso_caracs_list')); // redirection vers la liste des caractéristiques
        }

        return $this->render('admin/perso/caracs/edit.html.twig', [
            'carac' => $carac,
            'controller_name' => 'PersoCaracsController',
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Liste des caractéristiques
     * 
     * @return Response
     * 
     * @Route("", name="perso_caracs_list", methods={"GET"})
     */
    public function list(): Response
    {
        $caracs = $this->caracsRepository->findBy([], ['nom' => 'ASC']);
        
        return $this->render('admin/perso/caracs/list.html.twig', [
            'caracs' => $caracs,
            'controller_name' => 'PersoCaracsController',
        ]);
    }

    /**
     * Créer une caractéristique
     * 
     * @param Request $request
     * 
     * @return Response
     * 
     * @Route("/new", name="perso_caracs_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $carac = new Caracs();
        $form = $this->createForm(PersoCaracType::class, $carac);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($carac);
            $this->messageFlash('save_ok', 'caractéristique', false);
            return $this->redirect($this->generateUrl('perso_caracs_list')); // redirection vers la liste des caractéristiques
        }

        return $this->render('admin/perso/caracs/new.html.twig', [
            'carac' => $carac,
            'controller_name' => 'PersoCaracsController',
            'form' => $form->createView(),
        ]);
    }
}

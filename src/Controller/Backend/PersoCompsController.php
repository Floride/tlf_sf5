<?php
// src\Controller\Backend\PersoCompsController.php
namespace App\Controller\Backend;

use App\Entity\Comps;
use App\Form\PersoCompType;
use App\Repository\CompsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class PersoCompsController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/perso/competences")
 */
class PersoCompsController extends AbstractCrudController
{
    /**
     * @var CaracsRepository
     */
    private $compsRepository;

    /**
     * Constructor
     *
     * @param CompsRepository        $compsRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CompsRepository $compsRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->compsRepository = $compsRepository;
    }

    /**
     * Suppression d'une compétence
     *
     * @param Request $request
     * @param Comps   $comp
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="perso_comps_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Request $request, Comps $comp): Response
    {
        if ($this->isCsrfTokenValid('perso_comps_delete_' . $comp->getId(), $request->get('_token'))) {
            $this->suppression($comp);
            $this->messageFlash('delete_ok', 'compétence', false);
        } else {
            $this->messageFlash('csrf_bad');
        }

        return $this->redirect($this->generateUrl('perso_comps_list')); // redirection vers la liste des compétences
    }
    
    /**
     * Editer une compétence
     *
     * @param Request $request
     * @param Comps  $comp
     *
     * @return Response
     * 
     * @Route("/{id}/edit", name="perso_comps_edit", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function edit(Request $request, Comps $comp): Response
    {
        $form = $this->createForm(PersoCompType::class, $comp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($comp);
            $this->messageFlash('save_ok', 'compétence', false);
            return $this->redirect($this->generateUrl('perso_comps_list')); // redirection vers la liste des compétences
        }

        return $this->render('admin/perso/comps/edit.html.twig', [
            'comp' => $comp,
            'controller_name' => 'PersoCaracsController',
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * Liste des compétences
     * 
     * @param PaginatorInterface $paginator
     * @param Request $request
     * 
     * @return Response
     * 
     * @Route("", name="perso_comps_list", methods={"GET"})
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        $affichage = $request->get('affichage', 'liste');
        $comps = $paginator->paginate(
            $this->compsRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($affichage == 'liste') ? 8 : 8    // Limite par page
        );
        return $this->render('admin/perso/comps/list.html.twig', [
            'affichage' => $affichage,
            'comps' => $comps,
            'controller_name' => 'PersoCompsController',
        ]);
    }

    /**
     * Créer une compétence
     * 
     * @param Request $request
     * 
     * @return Response
     * 
     * @Route("/new", name="perso_comps_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $comp = new Comps();
        $form = $this->createForm(PersoCompType::class, $comp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($comp);
            $this->messageFlash('save_ok', 'compétence', false);
            return $this->redirect($this->generateUrl('perso_comps_list')); // redirection vers la liste des compétences
        }

        return $this->render('admin/perso/comps/new.html.twig', [
            'comp' => $comp,
            'controller_name' => 'PersoCompsController',
            'form' => $form->createView(),
        ]);
    }
}

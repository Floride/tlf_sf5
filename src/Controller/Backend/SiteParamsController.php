<?php
// src\Controller\Backend\SiteParamsController.php
namespace App\Controller\Backend;

use DateTime;
use App\Entity\SiteParams;
use App\Form\SiteParamType;
use App\Repository\SiteParamsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class SiteParamsController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin")
 */
class SiteParamsController extends AbstractCrudController
{
    /**
     * @var SiteParamsRepository
     */
    private $paramsRepository;

    /**
     * Constructor
     *
     * @param SiteParamsRepository   $paramsRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, SiteParamsRepository $paramsRepository)
    {
        parent::__construct($entityManager);
        $this->paramsRepository = $paramsRepository;

    }

    /**
     * Suppression d'un paramètre
     *
     * @param Request $request
     * @param SiteParams $param
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="site_params_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Request $request, SiteParams $param): Response
    {
        if ($this->isCsrfTokenValid('site_params_delete_' . $param->getId(), $request->get('_token'))) {
            $this->suppression($param);
            $this->messageFlash('delete_ok', 'paramètre');
        } else {
            $this->messageFlash('csrf_bad');
        }

        return $this->redirect($this->generateUrl('site_params_list')); // redirection vers la liste des Paramètres de site
    }

    /**
     * Editer un paramètre du site
     *
     * @param Request $request
     * @param SiteParams $param
     *
     * @return Response
     * 
     * @Route("/site/params/{id}/edit", name="site_params_edit", requirements={"id"="\d+"},  methods={"GET", "POST"})
     */
    public function edit(Request $request, SiteParams $param): Response
    {
        $form = $this->createForm(SiteParamType::class, $param);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($param);
            $this->messageFlash('save_ok', 'paramètre');
            return $this->redirect($this->generateUrl('site_params_list')); // redirection vers la liste des Paramètres de site
        }

        return $this->render('admin/site/params/edit.html.twig', [
            'controller_name' => 'SiteParamsController',
            'form' => $form->createView(),
            'param' => $param,
        ]);
    }

    /**
     * Liste des paramètres du site
     *
     * @param PaginatorInterface $paginator
     * @param Request $request
     * 
     * @return Response
     * 
     * @Route("/site/params", name="site_params_list", methods={"GET"})
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        $params = $paginator->paginate(
            $this->paramsRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            10                                  // Limite par page
        );
        
        return $this->render('admin/site/params/list.html.twig', [
            'controller_name' => 'SiteParamsController',
            'params' => $params
        ]);
    }
    
    /**
     * Créer un paramètre du site
     *
     * @param Request $request
     * @param SiteParams $siteParams
     *
     * @return Response
     * 
     * @Route("/site/params/new", name="site_params_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $param = new SiteParams();
        
        $form = $this->createForm(SiteParamType::class, $param);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($param);
            $this->messageFlash('save_ok', 'paramètre');
            return $this->redirect($this->generateUrl('site_params_list')); // redirection vers la liste des Paramètres de site
        }

        return $this->render('admin/site/params/new.html.twig', [
            'controller_name' => 'SiteParamsController',
            'form' => $form->createView(),
            'param' => $param,
        ]);
    }
}

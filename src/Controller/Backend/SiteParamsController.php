<?php
// src\Controller\Backend\SiteParamsController.php
namespace App\Controller\Backend;

use DateTime;
use App\Entity\SiteParams;
use App\Form\SiteParamType;
use App\Repository\SiteParamsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class AdminController
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
class SiteParamsController extends AbstractController
{
    /**
     * @var SiteParamsRepository
     */
    private $paramsRepository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * Constructor
     *
     * @param SiteParamsRepository   $userRepository
     * @param EntityManagerInterface $objectManager
     */
    public function __construct(SiteParamsRepository $paramsRepository, EntityManagerInterface $entityManager)
    {
        $this->paramsRepository = $paramsRepository;
        $this->manager = $entityManager;
    }

    /**
     * Editer un paramètre du site
     *
     * @param Request $request
     * @param SiteParams $siteParams
     *
     * @return Response
     * @Route("/site/params/{id}/edit", name="site_params_edit", requirements={"id"="\d+"},  methods={"GET", "POST"})
     */
    public function edit(Request $request, SiteParams $siteParams): Response
    {
        $param = $this->paramsRepository->findOneBy(['id' => $siteParams->getId()]);
        
        $form = $this->createForm(SiteParamType::class, $param);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush(); // Mise à jour du joueur en BDD
            $this->addFlash(
                'success',
                'Le paramètre a bien été modifié.'
            );
            return $this->redirect($this->generateUrl('site_params_list')); // redirection vers la liste des Paramètres de site
        }

        return $this->render('admin/site_params/edit.html.twig', [
            'controller_name' => 'SiteParamsController',
            'form' => $form->createView(),
            'param' => $param,
        ]);
    }

    /**
     * @Route("/site/params", name="site_params_list", methods={"GET"})
     */
    public function list(): Response
    {
        $params = $this->paramsRepository->findAll();
        
        return $this->render('admin/site_params/index.html.twig', [
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
     * @Route("/site/params/new", name="site_params_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $param = new SiteParams();
        
        $form = $this->createForm(SiteParamType::class, $param);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($param);  // On persiste l'objet $param
            $this->manager->flush(); // Mise à jour du joueur en BDD
            $this->addFlash(
                'success',
                'Le paramètre a bien été créé.'
            );
            return $this->redirect($this->generateUrl('site_params_list')); // redirection vers la liste des Paramètres de site
        }

        return $this->render('admin/site_params/new.html.twig', [
            'controller_name' => 'SiteParamsController',
            'form' => $form->createView(),
            'param' => $param,
        ]);
    }
}

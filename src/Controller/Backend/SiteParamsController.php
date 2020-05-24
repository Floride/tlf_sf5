<?php
// src\Controller\Backend\SiteParamsController.php
namespace App\Controller\Backend;

use DateTime;
use App\Entity\SiteParams;
use App\Repository\SiteParamsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * @Route("/site/params/{id}/edit", name="site_params_edit", requirements={"id"="\d+"},  methods={"GET", "POST"})
     */
    public function edit(): Response
    {
        $params = $this->paramsRepository->findAll();
        
        return $this->render('admin/site_params/index.html.twig', [
            'controller_name' => 'SiteParamsController',
            'params' => $params
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
}

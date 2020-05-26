<?php
// src\Controller\Backend\UsersController.php
namespace App\Controller\Backend;

use App\Entity\Caracs;
use App\Repository\CaracsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
class PersoCaracsController extends AbstractController
{
    /**
     * @var CaracsRepository
     */
    private $caracsRepository;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * Constructor
     *
     * @param CaracsRepository   $caracsRepository
     * @param EntityManagerInterface $objectManager
     */
    public function __construct(CaracsRepository $caracsRepository, EntityManagerInterface $entityManager)
    {
        $this->caracsRepository = $caracsRepository;
        $this->manager = $entityManager;
    }
    /**
     * @Route("", name="perso_caracs_list")
     */
    public function list()
    {
        $caracs = $this->caracsRepository->findAll();;
        return $this->render('admin/perso/caracs/list.html.twig', [
            'caracs' => $caracs,
            'controller_name' => 'PersoCaracsController',
        ]);
    }

    /**
     * @Route("/new", name="perso_caracs_new")
     */
    public function new()
    {
        $carac = new Caracs();
        return $this->render('admin/perso/caracs/new.html.twig', [
            'carac' => $carac,
            'controller_name' => 'PersoCaracsController',
        ]);
    }

    
    /**
     * @Route("/{id}/edit", name="perso_caracs_edit")
     */
    public function edit()
    {
        $carac = new Caracs();
        return $this->render('admin/perso/caracs/edit.html.twig', [
            'carac' => $carac,
            'controller_name' => 'PersoCaracsController',
        ]);
    }
}

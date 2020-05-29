<?php
// src\Controller\Backend\PersoCompsController.php
namespace App\Controller\Backend;

use App\Entity\Comps;
use App\Controller\AbstractCrudController;
use App\Repository\CompsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
     * Liste des compétences
     * 
     * @return Response
     * 
     * @Route("", name="perso_comps_list", methods={"GET"})
     */
    public function list()
    {
        return $this->render('admin/perso/comps/list.html.twig', [
            'controller_name' => 'PersoCompsController',
        ]);
    }
}

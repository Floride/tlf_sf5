<?php
// src\Controller\Backend\UsersController.php
namespace App\Controller\Backend;

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
     * @Route("", name="perso_caracs_list")
     */
    public function list()
    {
        $caracs = null;
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
        $caracs = new Caracs();
        return $this->render('admin/perso/caracs/list.html.twig', [
            'carac' => $carac,
            'controller_name' => 'PersoCaracsController',
        ]);
    }

    
    /**
     * @Route("/{id}/edit", name="perso_caracs_edit")
     */
    public function edit()
    {
        $caracs = new Caracs();
        return $this->render('admin/perso/caracs/list.html.twig', [
            'carac' => $carac,
            'controller_name' => 'PersoCaracsController',
        ]);
    }
}

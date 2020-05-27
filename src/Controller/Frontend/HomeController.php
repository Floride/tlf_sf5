<?php
//src\Controller\Frontend\HomeController.php
namespace App\Controller\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class HomeController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Frontend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class HomeController extends AbstractController
{
    /**
     * Page de Garde
     *
     * @return Response
     *
     * @Route("/", name="root", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * Page Accueil
     *
     * @return Response
     *
     * @Route("/accueil", name="accueil", methods={"GET"})
     */
    public function accueil(): Response
    {
        return $this->render('home/accueil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

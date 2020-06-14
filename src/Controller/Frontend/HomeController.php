<?php
//src\Controller\Frontend\HomeController.php
namespace App\Controller\Frontend;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class HomeController
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Frontend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @Route("",
 *      name="home_"
 * )
 */
class HomeController extends AbstractController
{
    /**
     * Page de Garde
     *
     * @return Response
     *
     * @Route("")
     * @Route("/",
     *      name="root",
     *      methods={"GET"}
     * )
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
     * @Route("/welcome",
     *      name="welcome", 
     *      methods={"GET"}
     * )
     */
    public function welcome(): Response
    {
        return $this->render('home/welcome.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}

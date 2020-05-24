<?php
//src\Controller\Frontend\UserController.php
namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Frontend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * Profil utilisateur (FrontEnd)
     * 
     * @return Response
     * 
     * @Route("/profil", name="user_profil", methods={"GET", "POST"})
     */
    public function profil()
    {
        return $this->render('user/profil.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}

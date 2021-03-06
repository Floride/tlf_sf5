<?php
// src\Controller\Backend\AdminController.php
namespace App\Controller\Backend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AdminController
 * Admin's actions
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin",
 *      name="admin_"
 * )
 */
class AdminController extends AbstractController
{
    /**
     * Welcome admin page
     *
     * @return Response
     *
     * @Route("",
     *      name="index", 
     *      methods={"GET"}
     * )
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }
    
    /**
     * List of all admin's actions
     *
     * @return Response
     *
     * @Route("/list",
     *      name="list", 
     *      methods={"GET"}
     * )
     */
    public function list(): Response
    {
        return $this->render('admin/list.html.twig');
    }
}

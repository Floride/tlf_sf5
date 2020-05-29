<?php
// src\Controller\Backend\AdminNavController.php
namespace App\Controller\Backend;

use App\Repository\SiteParamsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class AdminNavController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class AdminNavController extends AbstractController
{
    /**
     * @var SiteParamsRepository
     */
    private $paramsRepository;

    /**
     * Constructor
     *
     * @param SiteParamsRepository   $paramsRepository
     * 
     * @return void
     */
    public function __construct(SiteParamsRepository $paramsRepository)
    {
        $this->paramsRepository = $paramsRepository;
    }

    /**
     * Barre de navigation TOP
     *
     * @return Response
     */
    public function index(): Response
    {
        /**
         * @var SiteParams[]
         */
        $params = $this->paramsRepository->findBy([], ['nom' => 'ASC']);
        foreach ($params as $param) {
            $key = $param->getNom();
            $site[$key] = $param->getValeur();
        }

        return $this->render('admin/nav/index.html.twig', [
            'controller_name' => 'AdminNavController',
            'site' => $site,
        ]);
    }
}

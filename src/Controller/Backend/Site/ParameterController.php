<?php
// src\Controller\Backend\Site\ParameterController.php
namespace App\Controller\Backend\Site;

use DateTimeInterface;
use App\Entity\Site\Parameter;
use App\Form\Admin\Site\ParameterType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\Site\ParameterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class ParameterController
 * CRUD for Parameter class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/site/parameter",
 *      name="admin_site_parameter_"
 * )
 */
class ParameterController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_site_parameter_list';

    /**
     * @var ParameterRepository
     */
    private $parametereterRepository;

    /**
     * Constructor
     *
     * @param ParameterRepository   $parametereterRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, ParameterRepository $parametereterRepository)
    {
        parent::__construct($entityManager);
        $this->parameterRepository = $parametereterRepository;

    }

    /**
     * Delete
     *
     * @param Parameter $parameter
     * @param Request   $request
     *
     * @return Response
     *
     * @Route("/{id}/delete", 
     *      name="delete",
     *      requirements={"id"="\d+"},
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Parameter $parameter): Response
    {
        if ($this->isCsrfTokenValid('admin_site_parameter_delete_' . $parameter->getId(), $request->get('_token'))) {
            $this->suppression($parameter);
            $this->sendFlashMessage('delete_ok', 'paramètre');
        } else {
            $this->sendFlashMessage('csrf_bad');
        }
            
        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Edit
     *
     * @param Parameter $parameter
     * @param Request   $request
     *
     * @return Response
     * 
     * @Route("/site/parameter/{id}/edit", 
     *      name="edit", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Parameter $parameter): Response
    {
        $form = $this->createForm(ParameterType::class, $parameter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($parameter);
            $this->sendFlashMessage('save_ok', 'paramètre');
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/site/parameter/edit.html.twig', [
            'form' => $form->createView(),
            'param' => $parameter,
        ]);
    }

    /**
     * List
     *
     * @param PaginatorInterface $paginator
     * @param Request            $request
     * 
     * @return Response
     * 
     * @Route("/site/parameter", 
     *      name="list", 
     *      methods={"GET"}
     * )
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        $parameters = $paginator->paginate(
            $this->parameterRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            10                                  // Limite par page
        );
        
        return $this->render('admin/site/parameter/list.html.twig', [
            'parameters' => $parameters
        ]);
    }
    
    /**
     * New
     *
     * @param Request $request
     *
     * @return Response
     * 
     * @Route("/new", 
     *      name="new",
     *      methods={"GET", "POST"}
     * )
     */
    public function new(Request $request): Response
    {
        $parametereter = new Parameter();
        
        $form = $this->createForm(ParameterType::class, $parametereter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($parametereter);
            $this->sendFlashMessage('save_ok', 'paramètre');
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/site/parameter/new.html.twig', [
            'form' => $form->createView(),
            'parameter' => $parametereter,
        ]);
    }
}

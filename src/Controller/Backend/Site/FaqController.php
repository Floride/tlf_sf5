<?php
// src\Controller\Backend\Site\FaqController.php
namespace App\Controller\Backend\Site;

use DateTimeInterface;
use App\Entity\Site\Faq;
use App\Form\Admin\Site\FaqType;
use App\Repository\Site\FaqRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class FaqController
 * CRUD for FAQ class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/site/faq", 
 *      name="admin_site_faq_"
 * )
 */
class FaqController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_site_faq_list';

    /**
     * @var FaqRepository
     */
    private $faqRepository;

    /**
     * Constructor
     *
     * @param FaqRepository          $faqRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, FaqRepository $faqRepository)
    {
        parent::__construct($entityManager);
        $this->faqRepository = $faqRepository;

    }

    /**
     * Delete
     *
     * @param Faq     $faq
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Faq $faq): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_site_faq_delete_' . $faq->getId(), $request->get('_token'))) {
            $this->suppression($faq);
            $this->sendFlashMessage('delete_ok', 'F.A.Q', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Edit
     *
     * @param Faq     $faq
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * 
     * @Route("{id}/edit", 
     *      name="edit", 
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Faq $faq)
    {
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($faq);
            $this->sendFlashMessage('save_ok', 'F.A.Q', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/site/faq/edit.html.twig', [
            'form' => $form->createView(),
            'faq' => $faq,
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
     * @Route("", 
     *      name="list", 
     *      methods={"GET"}
     * )
     */
    public function list(Request $request, PaginatorInterface $paginator): Response
    {
        $faqs = $paginator->paginate(
            $this->faqRepository->findByQuestionQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            10                                  // Limite par page
        );

        return $this->render('admin/site/faq/list.html.twig', [
            'faqs' => $faqs
        ]);
    }
    
    /**
     * New
     *
     * @param Faq     $faq
     * @param Request $request
     *
     * @return RedirectResponse|Response
     * 
     * @Route("/new", 
     *      name="new", 
     *      methods={"GET", "POST"}
     * )
     */
    public function new(Request $request)
    {
        $faq = new Faq();
        
        $form = $this->createForm(FaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($faq);
            $this->sendFlashMessage('save_ok', 'F.A.Q', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/site/faq/new.html.twig', [
            'form' => $form->createView(),
            'faq' => $faq,
        ]);
    }
}

<?php
// src\Controller\Backend\SiteFaqsController.php
namespace App\Controller\Backend;

use DateTime;
use App\Entity\SiteFaqs;
use App\Form\SiteFaqType;
use App\Controller\AbstractCrudController;
use App\Repository\SiteFaqsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class SiteFaqsController
 *
 * PHP version 7.2
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin")
 */
class SiteFaqsController extends AbstractCrudController
{
    /**
     * @var SiteFaqsRepository
     */
    private $siteFaqsRepository;

    /**
     * Constructor
     *
     * @param SiteFaqsRepository   $siteFaqsRepository
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager, SiteFaqsRepository $siteFaqsRepository)
    {
        parent::__construct($entityManager);
        $this->siteFaqsRepository = $siteFaqsRepository;

    }

    /**
     * Suppression d'une F.A.Q
     *
     * @param Request $request
     * @param SiteFaqs $faqs
     *
     * @return Response
     *
     * @Route("/{id}/delete", name="site_faqs_delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Request $request, SiteFaqs $faq): Response
    {
        if ($this->isCsrfTokenValid('perso_faqs_delete_' . $faq->getId(), $request->get('_token'))) {
            $this->suppression($faq);
            $this->messageFlash('delete_ok', 'F.A.Q', false);
        } else {
            $this->messageFlash('csrf_bad');
        }

        return $this->redirect($this->generateUrl('site_faqs_list')); // redirection vers la liste des Paramètres de site
    }

    /**
     * Editer une F.A.Q
     *
     * @param Request $request
     * @param SiteFaqs $faq
     *
     * @return Response
     * 
     * @Route("/site/faqs/{id}/edit", name="site_faqs_edit", requirements={"id"="\d+"},  methods={"GET", "POST"})
     */
    public function edit(Request $request, SiteFaqs $faq): Response
    {
        $form = $this->createForm(SiteFaqType::class, $faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($faq);
            $this->messageFlash('save_ok', 'F.A.Q', false);
            return $this->redirect($this->generateUrl('site_faqs_list')); // redirection vers la liste des Paramètres de site
        }

        return $this->render('admin/site/faqs/edit.html.twig', [
            'controller_name' => 'SiteParamsController',
            'form' => $form->createView(),
            'faq' => $faq,
        ]);
    }

    /**
     * Liste des F.A.Q's
     *
     * @return Response
     * 
     * @Route("/site/faqs", name="site_faqs_list", methods={"GET"})
     */
    public function list(): Response
    {
        $faqs = $this->siteFaqsRepository->findAll();
        
        return $this->render('admin/site/faqs/list.html.twig', [
            'controller_name' => 'SiteParamsController',
            'faqs' => $faqs
        ]);
    }
    
    /**
     * Créer une F.A.Q's
     *
     * @param Request $request
     * @param SiteFaqs $faq
     *
     * @return Response
     * 
     * @Route("/site/faqs/new", name="site_faqs_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $faq = new SiteFaqs();
        
        $form = $this->createForm(SiteFaqType::class, $faq);
        $form->handleRequest($request);
        dump($form);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->sauvegarde($faq);
            $this->messageFlash('save_ok', 'F.A.Q', false);
            return $this->redirect($this->generateUrl('site_faqs_list')); // redirection vers la liste des Paramètres de site
        }

        return $this->render('admin/site/faqs/new.html.twig', [
            'controller_name' => 'SiteParamsController',
            'form' => $form->createView(),
            'faq' => $faq,
        ]);
    }
}

<?php
// src\Controller\Backend\Character\SkillController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Skill;
use App\Form\Admin\Character\SkillType;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\Character\SkillRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class SkillController
 * CRUD for Skill class
 *
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character/Skill",
 *      name="admin_character_skill_"
 * )
 */
class SkillController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_skill_list';

    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * SkillController Constructor
     *
     * @param SkillRepository        $skillRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(SkillRepository $skillRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->skillRepository = $skillRepository;
    }

    /**
     * Delete
     *
     * @param Request $request
     * @param Skill   $skill
     *
     * @return Response
     *
     * @Route("/{id}/delete",
     *      name="delete",
     *      requirements={"id"="\d+"},
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Skill $skill): Response
    {
        if ($this->isCsrfTokenValid('admin_character_skill_delete_' . $skill->getId(), $request->get('_token'))) {
            $this->suppression($skill);
            $this->sendFlashMessage('delete_ok', 'compétence', false);
        } else {
            $this->sendFlashMessage('csrf_bad');
        }
        
        return $this->redirectToRoute(self::RETURN_ROUTE);
    }
    
    /**
     * Edit
     *
     * @param Request $request
     * @param Skill   $skill
     *
     * @return Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, Skill $skill): Response
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($skill);
            $this->sendFlashMessage('save_ok', 'compétence', false);
            
            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/skill/edit.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * List
     * 
     * @param PaginatorInterface $paginator
     * @param Request $request
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
        $display = $request->get('display', 'list');
        $skills = $paginator->paginate(
            $this->skillRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12    // Limite par page
        );
        return $this->render('admin/character/skill/list.html.twig', [
            'display' => $display,
            'skills' => $skills,
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
        $skill = new Skill();
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($skill);
            $this->sendFlashMessage('save_ok', 'compétence', false);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/skill/new.html.twig', [
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }
}

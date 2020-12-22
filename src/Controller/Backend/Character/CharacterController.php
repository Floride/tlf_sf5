<?php
// src\Controller\Backend\Character\CharacterController.php
namespace App\Controller\Backend\Character;

use App\Entity\Character\Character;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\AbstractCrudController;
use App\Entity\Character\CharacterAffectation;
use App\Entity\Character\CharacterFeature;
use App\Entity\Character\CharacterMedal;
use App\Entity\Character\CharacterSkill;
use App\Entity\Character\Feature;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\Admin\Character\CharacterType;
use App\Repository\Character\CharacterFeatureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Character\CharacterRepository;
use App\Repository\Character\CharacterSkillRepository;
use App\Repository\Character\FeatureRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class CharacterController
 * CRUD for Character class
 * 
 * PHP version 7.2.5
 *
 * @package    App\Controller\Backend
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin/character",
 *      name="admin_character_"
 * )
 */
class CharacterController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_list';

    /**
     * @var CharacterRepository
     */
    private $characterRepository;

    /**
     * CharacterController Constructor
     *
     * @param CharacterRepository   $characterRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CharacterRepository $characterRepository, EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->characterRepository = $characterRepository;
    }

    /**
     * Default
     *
     * @param Request    $request
     * @param Character $character
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/default", 
     *      name="default", 
     *      requirements={"id"="\d+"}, 
     *      methods={"GET", "POST"}
     * )
     */
    public function default(Request $request, Character $character): Response
    {
        // Toutes les characters = false
        $characters = $this->characterRepository->findAll();
        foreach ($characters as $accred) {
            if ($accred != $character) {
                $accred->setDefault(false);
                $this->manager->persist($accred);
            }
        }
        $this->manager->flush();

        $character->setDefault(!$character->getDefault()); // Mise à jour statut is_default
        $this->save($character);

        return $this->redirectToRoute(self::RETURN_ROUTE);
    }

    /**
     * Delete
     *
     * @param Request    $request
     * @param Character $character
     *
     * @return RedirectResponse
     *
     * @Route("/{id}/delete", 
     *      name="delete", 
     *      requirements={"id"="\d+"}, 
     *      methods={"DELETE"}
     * )
     */
    public function delete(Request $request, Character $character): RedirectResponse
    {
        if ($this->isCsrfTokenValid('admin_character_delete_' . $character->getId(), $request->get('_token'))) {
            $this->suppression($character);
            $this->sendFlashMessage('delete_ok', 'personnage');
        } else {
            $this->sendFlashMessage('csrf_bad');
        }

        return $this->redirectToRoute(self::RETURN_ROUTE);
    
    }
    
    /**
     * Edit
     *
     * @param Request    $request
     * @param Character $character
     *
     * @return RedirectResponse|Response
     * 
     * @Route("/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(
            Request $request, 
            Character $character, 
            FeatureRepository $featureRepository
        ): Response
    {
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);
        
        if ($character->getFeatures()->isEmpty()) {
            $features = $featureRepository->findAllActive();
            $this->addFeatures($character, $features);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($character);
            $this->sendFlashMessage('save_ok', 'personnage');

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }
        
        return $this->render('admin/character/character/edit.html.twig', [
            'character' => $character,
            'form' => $form->createView()
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
        $display = $request->get('display', 'list');
        $characters = $paginator->paginate(
            $this->characterRepository->findByNameQuery(),
            $request->query->getInt('page', 1), // Numéro de page
            ($display == 'list') ? 25 : 12      // Limite par page
        );

        return $this->render('admin/character/character/list.html.twig', [
            'display' => $display,
            'characters' => $characters,
        ]);
    }

    /**
     * New
     * 
     * @param Request $request
     * 
     * @return RedirectResponse|Response
     * 
     * @Route("/new", 
     *      name="new", 
     *      methods={"GET", "POST"}
     * )
     */
    public function new(
            Request $request,
            FeatureRepository $featureRepository
        ): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($character);
            $this->sendFlashMessage('save_ok', 'personnage');
            
            // Charactéristiques
            $features = $featureRepository->findAllActive();
            $this->addFeatures($character, $features);

            return $this->redirectToRoute(self::RETURN_ROUTE);
        }

        return $this->render('admin/character/character/new.html.twig', [
            'character' => $character,
            'form' => $form->createView(),
        ]);
    }

    /**
     * addFeatures
     * 
     * @param Character $character
     * @param Feature[] $features
     * 
     * @return void
     */
    private function addFeatures(Character $character, array $features): void 
    {
        foreach ($features as $feature) {
            $min = $feature->getValueMin();
            $ave = $feature->getValueAverage();
            $max = $feature->getValueMax();
            $value = random_int($min, $max);
            
            switch (true) {
                case ($value > $max):
                    $value = $max;
                break;
                case ($value < $min):
                    $value = $min + ($min / 3);
                break;
            }
            $value -= $ave;

            $characterFeature = (New CharacterFeature())
                ->setCharacter($character)
                ->setFeature($feature)
                ->setValue($value)
                ->setExperienceUpgrade(0)
            ;

            $this->manager->persist($characterFeature);
        }

        $this->manager->flush();
        
        return;
    }
}

<?php

namespace App\Controller\Backend\Character;

use App\Controller\AbstractCrudController;
use App\Entity\Character\CharacterFeature;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Admin\Character\CharacterFeatureType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class CharacterFeatureController
 * update for CharacterFeature class
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
 *      name="admin_character_character_feature_"
 * )
 */
class CharacterFeatureController extends AbstractCrudController
{
    const RETURN_ROUTE = 'admin_character_edit';

    /**
     * Edit
     *
     * @param Request          $request
     * @param CharacterFeature $characterFeature

     *
     * @return RedirectResponse|Response
     * 
     * @Route("/character_feature/{id}/edit",
     *      name="edit",
     *      requirements={"id"="\d+"},
     *      methods={"GET", "POST"}
     * )
     */
    public function edit(Request $request, CharacterFeature $characterFeature): Response
    {
        $form = $this->createForm(
            CharacterFeatureType::class, 
            $characterFeature, 
            [
                'action' => $this->generateUrl('admin_character_character_feature_edit', ['id' => $characterFeature->getId()])
            ]
        );

        dump($form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->save($characterFeature);
            $this->sendFlashMessage('save_ok', 'personnage');

            return $this->redirectToRoute(self::RETURN_ROUTE, ['id' => $characterFeature->getCharacter()->getId()]);
        }

        return $this->render('admin/character/character/feature/edit.html.twig', [
            'characterFeature' => $characterFeature,
            'form' => $form->createView()
        ]);
    }
    
}

<?php
// src\Controller\AbstractCrudController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Abstract Class AbstractCrudController
 *
 * PHP version 7.2
 *
 * @package    App\Controller
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
abstract class AbstractCrudController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $objectManager
     * 
     * @return void
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    /**
     * Créé un message flash
     *
     * @param string      $categorie
     * @param string|null $element
     * @param string|null $masculin
     *
     * @return void
     */
    protected function messageFlash(string $categorie, ?string $element = 'enregistrement', ?bool $masculin = true): void
    {
        $type = 'success';
        $element = $this->elide($element, $masculin);

        switch ($categorie) {
            case 'delete_ok': // supression OK
                $message = sprintf('%s a bien été supprimé.', $element);
                // no break
            case 'save_ok': // enregistrement OK
                $message = sprintf('%s a bien été sauvegardé.', $element);
            break;
            case 'status_bad': // mauvais status
                $type = 'danger';
                $message = sprintf('%s ne peut pas être supprimé à cause de son statut (Actif).', $element);
            break;
            case 'csrf_bad': // Token CSRF invalide
                $type = 'danger';
                $message = 'Impossible de valider le formulaire (Token CSRF).';
            break;
        }

        $this->addFlash($type, $message);

        return;
    }

    /**
     * sauvegarde
     *
     * @param object $object
     * 
     * @return void
     */
    protected function sauvegarde(object $object): void
    {
        $this->manager->persist($object); // On persiste l'objet
        $this->manager->flush(); // On enregistre en BDD

        return;
    }

    /**
     * suppression
     *
     * @param object $object
     * 
     * @return void
     */
    protected function suppression(object $object): void
    {
        $this->manager->remove($object);    // On retire l'objet
        $this->manager->flush();            // On enregistre en BDD

        return;
    }

    /**
     * elide
     * 
     * @param string|null $chaine
     * @param bool|null $masculin
     * 
     * @return string
     */
    private function elide(?string $chaine = 'enregistrement', ?bool $masculin = true): string
    {
        $elides = ['a', 'o', 'e', 'i', 'u', 'y', 'h'];
        $type = 'success';

        $el = $this->enleveaccents($chaine);
        
        if (in_array(substr($el, 0, 1), $elides)) {
            $element = 'L\'' . $chaine; // Elidé
        } else {
            if ($masculin) {
                $element = 'Le ' . $element[0]; // Masculin
            } else {
                $element = 'La ' . $element[0]; // Féminin
            }
        }

        return (string) $chaine;
    }

    /**
     * enleveaccents
     *
     * @param string $chaine
     * 
     * @return string
     */
    private function enleveaccents(string $chaine): string
    {
        $chaine = strtr(
             $chaine,
             "ÀÁÂàÄÅàáâàäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
             "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"
         );

        return (string) $chaine;
    }
}

<?php
// src\Controller\AbstractCrudController.php
namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Abstract Class AbstractCrudController
 *
 * PHP version 7.2.5
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
     * AbstractCrudController Constructor
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
     * @param string      $category
     * @param string|null $element
     * @param bool|null   $male
     *
     * @return void
     */
    protected function sendFlashMessage(string $category, ?string $element = 'enregistrement', ?bool $male = true): void
    {
        $type = 'success';
        $element = $this->elide($element, $male);

        switch ($category) {
            case 'active_bad': // mauvais status
                $type = 'danger';
                $message = sprintf(
                    '%s ne peut pas être supprimé%s à cause de son statut (Actif).', 
                    $element, 
                    ($male)?'':'e'
                );
            break;
            case 'ban_bad': // mauvais status
                $type = 'danger';
                $message = sprintf(
                    '%s ne peut pas être supprimé%s à cause de son statut (Banni).', 
                    $element, 
                    ($male)?'':'e'
                );
            break;
            case 'csrf_bad': // Token CSRF invalide
                $type = 'danger';
                $message = 'Impossible de valider le formulaire (Token CSRF).';
            break;
            case 'delete_ok': // supression OK
                $message = sprintf(
                    '%s a bien été supprimé%s.', 
                    $element, 
                    ($male)?'':'e'
                );
            break;
            case 'obsolete_bad': // mauvais status
                $type = 'danger';
                $message = sprintf(
                    '%s ne peut pas être supprimé%s à cause de son statut (Obsolete).', 
                    $element, 
                    ($male)?'':'e'
                );
            break;
            case 'save_ok': // enregistrement OK
                $message = sprintf(
                    '%s a bien été sauvegardé%s.', 
                    $element, 
                    ($male)?'':'e'
                );
            break;
        }

        $this->addFlash($type, $message);

        return;
    }

    /**
     * save
     *
     * @param object $object
     * 
     * @return void
     */
    protected function save(object $object): void
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
     * @param string|null $string
     * @param bool|null   $male
     * 
     * @return string
     */
    private function elide(?string $string = 'enregistrement', ?bool $male = true): string
    {
        $elids = ['a', 'o', 'e', 'i', 'u', 'y', 'h'];

        $firstLetter = $this->removeAccents(substr($string, 0, 1));
        
        if (in_array($firstLetter, $elids)) {
            $string = 'L\'' . $string; // Elidé
        } else {
            $string =  ($male) ? 'Le ' . $string : 'La ' . $string;
        }

        return (string) $string;
    }

    /**
     * removeAccents
     *
     * @param string $string
     * 
     * @return string
     */
    private function removeAccents(string $string): string
    {
        $string = strtr(
             $string,
             "ÀÁÂàÄÅàáâàäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",
             "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"
         );

        return (string) $string;
    }
}

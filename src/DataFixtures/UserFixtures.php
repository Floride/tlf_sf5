<?php
// src\DataFixtures\UserFixtures.php
namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 *
 * PHP version 7.2
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * Constructor
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return void
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * Load
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Les noms d'utilisateurs à créer
        $listNames = [
            'Demo', 
            'Nicolas', 
            'Sylvain', 
            'Alexandre', 
            'Marine', 
            'Anna'
        ];
        
        // On crée l'utilisateur (un Testeur par defaut)
        $user = new User();

        $user->setDateNaissance(new DateTime('2001-01-01')) // On définit la date de naissance
            ->setEmail('testuser@tlf.fr') // On définit l'adresse mail
            ->setUsername('Testeur') // On définit le username
            ->setEnabled(true) // On définit le compte comme actif
            ->setValided(true) // On définit le compte comme validé
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            )) // On définit le mot de passe
            ->setRoles(['ROLE_USER']); // On définit uniquement le role ROLE_USER qui est le role de base

        // On persiste l'objet $user
        $manager->persist($user);
       
        foreach ($listNames as $name) {
            $user = new User(); // On crée l'un des utilisateurs de la liste
            $user->setEmail(strtolower($name) . '@tlf.fr') // On définit l'adresse mail
                ->setEnabled(true) // On définit le compte comme actif
                ->setValided(false) // On définit le compte comme non validé
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    $name
                )); // On définit le mot de passe
            switch ($name) {
                case 'Nicolas':
                case 'Sylvain':
                    // On définit uniquement le role ROLE_ADMIN
                    $user->setRoles(['ROLE_ADMIN']);
                    break;
                default:
                    // On définit uniquement le role ROLE_USER qui est le role de base
                    $user->setRoles(['ROLE_USER']);
                    break;
            }
            // On persiste l'objet $user
            $manager->persist($user);
        }
        // On enregistre en BDD
        $manager->flush();

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder():int {
        return 100;
    }
}

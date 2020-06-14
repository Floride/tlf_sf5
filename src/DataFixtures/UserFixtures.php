<?php
// src\DataFixtures\UserFixtures.php
namespace App\DataFixtures;

use DateTimeImmutable;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.1
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
        $listUsers = $this->getData();
        
        // On crée l'utilisateur (un Testeur par defaut)
        $user = new User();

        $user->setBirthDate(new DateTimeImmutable('2001-06-15')) // On définit la date de naissance
            ->setEmail('testuser@tlf.fr') // On définit l'adresse mail
            ->setUsername('Testeur') // On définit le username
            ->setEnable(true) // On définit le compte comme actif
            ->setValid(true) // On définit le compte comme validé
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            )) // On définit le mot de passe
            ->setRoles(['ROLE_USER']) // On définit uniquement le role ROLE_USER qui est le role de base
            ->setBan(false) // Pas banni
        ;

        // On persiste l'objet $user
        $manager->persist($user);
       
        foreach ($listUsers as $u) {
            $user = new User(); // On crée l'un des utilisateurs de la list
            $user->setEmail(strtolower($u) . '@tlf.fr') // On définit l'adresse mail
                ->setUsername($u) // On définit le username
                ->setEnable(true) // On définit le compte comme actif
                ->setValid(false) // On définit le compte comme non validé
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    $u
                )) // On définit le mot de passe
                ->setBan(false) // Pas banni
            ;
            switch ($u) {
                case 'Nicolas':
                    $user->setValid(true); // On définit le compte comme validé
                case 'Sylvain':
                    // On définit le role ROLE_ADMIN
                    $user->setRoles(['ROLE_ADMIN']);
                    break;
                case 'Anna':
                    // On définit le role ROLE_USER qui est le role de base
                    $user->setRoles(['ROLE_USER'])
                        ->setBan(true) // Bannie
                    ;
                    break;
                default:
                    // On définit le role ROLE_USER qui est le role de base
                    $user->setRoles(['ROLE_USER']);
                    break;
            }

            $manager->persist($user); // On persiste l'objet $user
        }

        $manager->flush(); // On enregistre en BDD

        return;
    }

    /**
     * Get data
     *
     * @return array
     */
    private function getData(): array
    {
        return [
            'Demo',
            'Nicolas',
            'Sylvain',
            'Alexandre',
            'Marine',
            'Anna'
        ];
    }
}

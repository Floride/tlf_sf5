<?php
// src\DataFixtures\Character\ProfessionFixtures.php
namespace App\DataFixtures\Character;

use Faker\Factory;
use App\Entity\Character\Profession;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class ProfessionFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class ProfessionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $listProfession = $this->getData();

        foreach ($listProfession as $p) {
            $profession = (new Profession())
                ->setName($p['name'])
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
                ->setType($p['type'])
                ->setPlayable($p['playable'])
            ;

            $manager->persist($profession);
        }

        $manager->flush();
    }
    
    /**
     * Get data
     *
     * @return array
     */
    private function getData(): array
    {
        return [
            [
                'name' => 'Artilleur',
                'type' => 1,
                'playable' => true
            ],
            [
                'name' => 'Grenadier Voltigeur',
                'type' => 1,
                'playable' => true,
            ],
            [
                'name' => 'Infirmier',
                'type' => 3,
                'playable' => true,
            ],
            [
                'name' => 'Médecin',
                'type' => 3,
                'playable' => false,
            ],
            [
                'name' => 'Technicien',
                'type' => 3,
                'playable' => true,
            ],
            [
                'name' => 'Tirailleur',
                'type' => 1,
                'playable' => true,
            ],
            [
                'name' => 'Politicien',
                'type' => 2,
                'playable' => false,
            ],
            [
                'name' => 'Ingenieur',
                'type' => 2,
                'playable' => false,
            ],
            [
                'name' => 'Rebelle',
                'type' => 2,
                'playable' => false,
            ]
        ];
    }
}

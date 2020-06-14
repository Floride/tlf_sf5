<?php
// src\DataFixtures\Character\MedalFixtures.php
namespace App\DataFixtures\Character;

use Faker\Factory;
use App\Entity\Character\Medal;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class MedalFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class MedalFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listMedals = $this->getData();

        foreach ($listMedals as $m) {
            $medal = (new Medal())
                ->setName($m['name'])
                ->setAbbreviation($m['abbreviation'])
                ->setDescription($faker->paragraph(5, true))
                ->setType($m['type'])
                ->setCategory($m['category'])
                ->setObsolete(false)
                ->setValue($m['value'])
                ->setcoeficientXp((isset($m['coefXP'])) ? $m['coefXP'] : 0);
            ;

            $manager->persist($medal);
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
        // TYPE = 0: Non specifié, 1: Individuelle, 2: Unité, 3: Mixte
        // CATEGORY = 0: Non specifié, 1: Achèvement, 2: Honneur, 3: Bravoure, 4: Regimentaire, 5: Fédérale, 6: Autre
        
        return [
            [
                'name' => 'Etoile de la Fédération',
                'abbreviation' => 'FSM',
                'type' => 1,
                'category' => 3,
                'value' => 400,
                'coefXP' => 1
            ],
            [
                'name' => 'Etoile d\'Argent',
                'abbreviation' => 'SSM',
                'type' => 1,
                'category' => 3,
                'value' => 300,
                'coefXP' => 1
            ],
            [
                'name' => 'Etoile de Bronze',
                'abbreviation' => 'BSM',
                'type' => 1,
                'category' => 3,
                'value' => 250,
                'coefXP' => 1
            ],
            [
                'name' => 'Croix d\'Argent',
                'abbreviation' => 'SCM',
                'type' => 1,
                'category' => 2,
                'value' => 220,
                'coefXP' => 0.5
            ],
            [
                'name' => 'Croix de Bronze',
                'abbreviation' => 'BCM',
                'type' => 1,
                'category' => 2,
                'value' => 200,
                'coefXP' => 0.5
            ],
            [
                'name' => 'Croix de Fer',
                'abbreviation' => 'STCM',
                'type' => 1,
                'category' => 2,
                'value' => 180,
                'coefXP' => 0.25
            ],
            [
                'name' => 'Médaille Synople',
                'abbreviation' => 'MA-VI',
                'type' => 1,
                'category' => 1,
                'value' => 15
            ],
            [
                'name' => 'Médaille Azur',
                'abbreviation' => 'MA-V',
                'type' => 1,
                'category' => 1,
                'value' => 20
            ],
            [
                'name' => 'Médaille Orangée',
                'abbreviation' => 'MA-IV',
                'type' => 1,
                'category' => 1,
                'value' => 25
            ],
            [
                'name' => 'Médaille Carmin',
                'abbreviation' => 'MA-III',
                'type' => 1,
                'category' => 1,
                'value' => 30
            ],
            [
                'name' => 'Médaille Pourpre',
                'abbreviation' => 'MA-II',
                'type' => 1,
                'category' => 1,
                'value' => 35,
                'coefXP' => 0.1
            ],
            [
                'name' => 'Médaille Eben',
                'abbreviation' => 'MA-I',
                'type' => 1,
                'category' => 1,
                'value' => 50,
                'coefXP' => 0.1
            ],
            [
                'name' => 'Médaille Ivoire',
                'abbreviation' => 'MM-I',
                'type' => 1,
                'category' => 1,
                'value' => 50,
                'coefXP' => 0.1
            ],
            [
                'name' => 'Coeur Carmin',
                'abbreviation' => 'CHM',
                'type' => 1,
                'category' => 4,
                'value' => 150,
                'coefXP' => 0.2
            ],
            [
                'name' => 'Coeur Pourpre',
                'abbreviation' => 'PHM',
                'type' => 1,
                'category' => 4,
                'value' => 150,
                'coefXP' => 0.2
            ],
            [
                'name' => 'Médaille de la Légion Fédérale',
                'abbreviation' => 'FLM',
                'type' => 3,
                'category' => 5,
                'value' => 800,
                'coefXP' => 0.5
            ],
            [
                'name' => 'Médaille de l\'Infanterie Mobile',
                'abbreviation' => 'MIM',
                'type' => 3,
                'category' => 5,
                'value' => 800,
                'coefXP' => 0.5
            ],
            [
                'name' => 'Citation Fédérale',
                'abbreviation' => 'CM',
                'type' => 2,
                'category' => 5,
                'value' => 300,
                'coefXP' => 0.8
            ],
            [
                'name' => 'Médaille d\'Honneur de la Fédération',
                'abbreviation' => 'FHM',
                'type' => 1,
                'category' => 5,
                'value' => 2000,
                'coefXP' => 2
            ],
        ];
    }
}

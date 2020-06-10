<?php
// src\DataFixtures\Character\AccreditationFixtures.php
namespace App\DataFixtures\Character;

use Faker\Factory;
use App\Entity\Character\Accreditation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class AccreditationFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class AccreditationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listAccreditations = $this->getData();
        
        foreach($listAccreditations as $a) {
            $accreditation = (new Accreditation())
                ->setName($a['name'])
                ->setAbbreviation($a['abbreviation'])
                ->setDescription($faker->paragraph(5, true))
                ->setCategory($a['category'])
                ->setType($a['type'])
                ->setPlayable((isset($a['playable']) && !$a['playable']) ? false : true)
                ->setDefault((isset($a['default'])) ? true : false)
                ->setLevel($a['level'])
            ;

            $manager->persist($accreditation);
        }

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder():int
    {
        return 1000;
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
                'name' => 'Accès Libre',
                'abbreviation' => 'AL',
                'type' => 3,
                'level' => 0,
                'category' => 0,
                'default' => true
            ],
            [
                'name' => 'Accès Restreint',
                'abbreviation' => 'AR',
                'type' => 2,
                'level' => 1,
                'category' => 0
            ],
            [
                'name' => 'Accès Confidentiel',
                'abbreviation' => 'AC',
                'type' => 2,
                'level' => 2,
                'category' => 0
            ],
            [
                'name' => 'Accès Confidentiel Défence',
                'abbreviation' => 'ACD',
                'type' => 1,
                'level' => 2,
                'category' => 0
            ],
            [
                'name' => 'Accès Confidentiel Défence - Légion Fédérale',
                'abbreviation' => 'ACDL',
                'type' => 1,
                'level' => 2,
                'category' => 1
            ],
            [
                'name' => 'Accès Confidentiel Défence - Infanterie Mobile',
                'abbreviation' => 'ACIM',
                'type' => 1,
                'level' => 2,
                'category' => 1
            ],
            [
                'name' => 'Accès Confidentiel Défence - Sous-Officier',
                'abbreviation' => 'ACSO',
                'type' => 1,
                'level' => 3,
                'category' => 1
            ],
            [
                'name' => 'Accès Confidentiel Défence - Officier',
                'abbreviation' => 'ACO',
                'type' => 1,
                'level' => 4,
                'category' => 1
            ],
            [
                'name' => 'Accès Régimentaire IV',
                'abbreviation' => 'AR-IV',
                'type' => 1,
                'level' => 4,
                'category' => 1
            ],
            [
                'name' => 'Accès Régimentaire III',
                'abbreviation' => 'AR-III',
                'type' => 1,
                'level' => 5,
                'category' => 1
            ],
            [
                'name' => 'Accès Régimentaire II',
                'abbreviation' => 'AR-II',
                'type' => 1,
                'level' => 6,
                'category' => 1
            ],
            [
                'name' => 'Accès Régimentaire I',
                'abbreviation' => 'AR-I',
                'type' => 1,
                'level' => 7,
                'category' => 2
            ],
            [
                'name' => 'Accès Confidentiel Médical III',
                'abbreviation' => 'M-III',
                'type' => 3,
                'level' => 4,
                'category' => 1
            ],
            [
                'name' => 'Accès Confidentiel Médical II',
                'abbreviation' => 'M-II',
                'type' => 3,
                'level' => 5,
                'category' => 3
            ],
            [
                'name' => 'Accès Confidentiel Médical I',
                'abbreviation' => 'M-I',
                'type' => 3,
                'level' => 6,
                'category' => 3
            ],
            [
                'name' => 'Accès Confidentiel Fédéral II',
                'abbreviation' => 'ACF-II',
                'type' => 3,
                'level' => 7,
                'category' => 3
            ],
            [
                'name' => 'Accès Confidentiel Fédéral I',
                'abbreviation' => 'ACF-I',
                'type' => 3,
                'level' => 8,
                'category' => 3
            ],
        ];
    }
}

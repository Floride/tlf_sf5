<?php
// src\DataFixtures\Game\Geo\LuminaryTypeFixtures.php
namespace App\DataFixtures\Game\Geo;

use Faker\Factory;
use App\Entity\Game\Geo\LuminaryType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class LuminaryTypeFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class LuminaryTypeFixtures extends Fixture
{   
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listType = $this->getData();

        foreach ($listType as $t) {
            $luminary = (new LuminaryType())
                ->setName($t)
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
            ;
            
            $manager->persist($luminary);
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
            'Etoile',
            'Planète naine',
            'Planète tellurique',
            'Géante gazeuse',
            'Satellite',
            'Vaisseau spatial',
            'Station Orbitale',
            'Comète',
            'Astéroïde',
            'Pulsar',
            'Nébuleuse',
            'Galaxie'
        ];
    }
}

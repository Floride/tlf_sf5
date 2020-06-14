<?php
// src\DataFixtures\Game\Geo\PlaceTypeFixtures.php
namespace App\DataFixtures\Game\Geo;

use Faker\Factory;
use App\Entity\Game\Geo\PlaceType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class PlaceTypeFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class PlaceTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listType = $this->getData();

        foreach ($listType as $t) {
            $placeType = (new PlaceType())
                ->setName($t)
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
            ;
            
            $manager->persist($placeType);
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
            'Village',
            'Ville',
            'Cité',
            'Métroplexe',
            'District',
            'Lac',
            'Mer',
            'Océan',
            'Colline',
            'Montagne',
            'Station Orbitale',
            'Base Scientifique',
            'Vaisseau Spatial'
        ];
    }
}

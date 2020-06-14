<?php
// src\DataFixtures\Game\Geo\PlaceFixtures.php
namespace App\DataFixtures\Game\Geo;

use Faker\Factory;
use App\Entity\Game\Geo\Place;
use App\Entity\Game\Geo\Luminary;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\Game\Geo\PlaceRepository;
use App\DataFixtures\Game\Geo\LuminaryFixtures;
use App\Repository\Game\Geo\LuminaryRepository;
use App\DataFixtures\Game\Geo\PlaceTypeFixtures;
use App\Repository\Game\Geo\PlaceTypeRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class PlaceFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class PlaceFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var LuminaryRepository 
     */
    private $luminaryRepository;

    /**
     * @var PlaceRepository
     */
    private $placeRepository;

    /**
     * @var PlaceTypeRepository
     */
    private $placeTypeRepository;

    /**
     * PlaceFixtures Constructor
     *
     * @param LuminaryRepository $luminaryRepository
     * @param PlaceRepository $placeRepository
     * @param PlaceTypeRepository $placeTypeRepository
     * 
     * @return void
     */
    public function __construct(PlaceTypeRepository $placeTypeRepository, LuminaryRepository $luminaryRepository, PlaceRepository $placeRepository)
    {
        $this->luminaryRepository = $luminaryRepository;
        $this->placeRepository = $placeRepository;
        $this->placeTypeRepository = $placeTypeRepository;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $list = $this->getData();

        for ($i=0; $i < 100; $i++) {
            $place = (new Place())
                ->setName($faker->firstname())
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
                ->setType($list[random_int(0, count($list) - 1)])
            ;
            
            $manager->persist($place);
        }

        $manager->flush();

        $this->updateLuminary($manager);
        
        $this->updateParent($manager);
    }

    public function getDependencies(): array
    {
        return [
            LuminaryFixtures::class,
            PlaceTypeFixtures::class,
        ];
    }
    
    /**
     * Get data
     *
     * @return array
     */
    private function getData(): array
    {
        /**
         * @var array
         */
        $type = [];
        /**
         * @var PlaceType[]|null
         */
        $data = $this->placeTypeRepository->findAll();
        $i = 0;

        foreach ($data as $value) {
            $type[$i] = $value;
            $i++;
        }

        return $type;
    }

    /**
     * updateLuminary
     *
     * @param ObjectManager $manager
     * 
     * @return void
     */
    private function updateLuminary(ObjectManager $manager): void
    {
        /*
            'District', // Planète Tellurique
            'Océan', // Planète Tellurique
            'Base Scientifique', // Astéroïde, naine, Gazeuse, Satellite
        */
        $faker = Factory::create('en_US');
        
        /**
         * @var Place[]|null
         */
        $places = $this->placeRepository->findAll();
        /**
         * @var Luminary[]|null
         */
        $luminaries = $this->luminaryRepository->findAll();
        $p = 0;
        $s = 0;

        foreach ($luminaries as $value) {
            switch ($value->getType()->getName()) {
                case 'Planète tellurique':
                    $tellurique[$p] = $value;
                    $p++;
                break;
                case 'Astéroïde':
                case 'Satellite':
                case 'Géante gazeuse':
                case 'Planète naine':
                    $scientifique[$s] = $value;
                    $s++;
                break;
            }
        }

        foreach ($places as $place) {
            // echo $luminary->getType()->getName() . ' ' . $luminary->getName() . PHP_EOL;
            switch ($place->getType()->getName()) {
                case 'Océan':
                    $place->setName($faker->firstname('Male'));
                case 'District':
                    $place->setLuminary($tellurique[random_int(0, count($tellurique) - 1)]);
                break;
                case 'Base Scientifique':
                    $place->setName($faker->name());
                    $place->setLuminary($scientifique[random_int(0, count($scientifique) - 1)]);
                break;
            }
            /* 
            if ($place->getAround()) {
                echo '---->' . $place->getAround()->getType()->getName() . ' ' . $place->getAround()->getName() . PHP_EOL;
            } else {
                echo '---->N/A' . PHP_EOL;
            }
            */
            $manager->persist($place);
        }
        
        $manager->flush();

        return;
    }

    
    /**
     * updateParent
     *
     * @param ObjectManager $manager
     * 
     * @return void
     */
    private function updateParent(ObjectManager $manager): void
    {
        /*
            'Village', // District
            'Ville', // District
            'Cité', // District
            'Métroplexe', // District
            'Colline', // District SetName firstname(Female)
            'Montagne', // District SetName firstname(Female)
            'Lac', // District SetName firstname(Male)
            'Mer', // District SetName firstname(Female)
        */
        $faker = Factory::create('fr_FR');
        
        /**
         * @var Place[]|null
         */
        $places = $this->placeRepository->findAll();
        
        foreach ($places as $place) {
            if ('District' == $place->getType()->getName()) {
                $parents[] = $place;
            }
        }

        foreach ($places as $place) {
            // echo $luminary->getType()->getName() . ' ' . $luminary->getName() . PHP_EOL;
            switch ($place->getType()->getName()) {
                case 'Lac':
                    $place->setName($faker->firstname('Male'));
                    $place->setParent($parents[random_int(0, count($parents) - 1)]);
                break;
                case 'Colline':
                case 'Montagne':
                case 'Mer':
                    $place->setName($faker->firstname('Female'));
                    $place->setParent($parents[random_int(0, count($parents) - 1)]);
                break;
                case 'Village':
                case 'Ville':
                case 'Cité':
                case 'Métroplexe':
                    $place->setParent($parents[random_int(0, count($parents) - 1)]);
                break;
            }
            /* 
            if ($place->getAround()) {
                echo '---->' . $place->getAround()->getType()->getName() . ' ' . $place->getAround()->getName() . PHP_EOL;
            } else {
                echo '---->N/A' . PHP_EOL;
            }
            */
            $manager->persist($place);
        }

        $manager->flush();

        return;
    }
}

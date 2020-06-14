<?php
// src\DataFixtures\Game\Geo\LuminaryFixtures.php
namespace App\DataFixtures\Game\Geo;

use Faker\Factory;
use App\Entity\Game\Geo\Luminary;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\Game\Geo\LuminaryRepository;
use App\Repository\Game\Geo\LuminaryTypeRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class LuminaryFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class LuminaryFixtures extends Fixture implements DependentFixtureInterface
{
    
    /**
     * @var LuminaryRepository
     */
    private $luminaryRepository;

    /**
     * @var LuminaryTypeRepository
     */
    private $luminaryTypeRepository;

    /**
     * LuminaryFixtures Constructor
     *
     * @param LuminaryRepository $luminaryRepository
     * @param LuminaryTypeRepository $luminaryTypeRepository
     * 
     * @return void
     */
    public function __construct(LuminaryRepository $luminaryRepository, LuminaryTypeRepository $luminaryTypeRepository)
    {
        $this->luminaryRepository = $luminaryRepository;
        $this->luminaryTypeRepository = $luminaryTypeRepository;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $list = $this->getData();

        $luminary = (new Luminary())
            ->setName('Galade')
            ->setDescription($faker->paragraph(5, true))
            ->setObsolete(false)
            ->setType($this->luminaryTypeRepository->findOneBy(['name' => 'Galaxie']))
        ;
        
        $manager->persist($luminary);
        
        $luminary = (new Luminary())
            ->setName('Hélios')
            ->setDescription($faker->paragraph(5, true))
            ->setObsolete(false)
            ->setType($this->luminaryTypeRepository->findOneBy(['name' => 'Etoile']))
        ;
        
        $manager->persist($luminary);
        
        $luminary = (new Luminary())
            ->setName('Gaia')
            ->setDescription($faker->paragraph(5, true))
            ->setObsolete(false)
            ->setType($this->luminaryTypeRepository->findOneBy(['name' => 'Planète tellurique']))
        ;
        
        $manager->persist($luminary);

        for ($i = 0; $i < 50; $i++) {
            $luminary = (new Luminary())
                ->setName($faker->firstname('female'))
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
                ->setType($list[random_int(0, count($list) - 1)])
            ;
            
            $manager->persist($luminary);
        }

        $manager->flush();
        
        $this->updateAround($manager);
    }
    
    public function getDependencies(): array
    {
        return [
            LuminaryTypeFixtures::class,
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
         * @var LuminaryType[]|null
         */
        $data = $this->luminaryTypeRepository->findAll();
        $i = 0;

        foreach ($data as $value) {
            $type[$i] = $value;
            $i++;
        }

        return $type;
    }

    /**
     * updateParent
     *
     * @param ObjectManager $manager
     * 
     * @return void
     */
    private function updateAround(ObjectManager $manager): void
    {
        /**
         * @var Luminary[]|null
         */
        $luminaries = $this->luminaryRepository->findAll();
        $p = 0;
        $s = 0;

        foreach ($luminaries as $value) {
            switch ($value->getType()->getName()) {
                case 'Etoile':
                    $star[$s] = $value;
                    $s++;
                break;
                case 'Géante gazeuse':
                case 'Planète naine':
                case 'Planète tellurique':
                    $planetoid[$p] = $value;
                    $p++;
                break;
            }
        }

        foreach ($luminaries as $luminary) {
            // echo $luminary->getType()->getName() . ' ' . $luminary->getName() . PHP_EOL;
            switch ($luminary->getName()) {
                case 'Hélios':
                    $luminary->setAround($this->luminaryRepository->findOneBy(['name' => 'Galade']));
                break;
                case 'Gaia':
                    $luminary->setAround($this->luminaryRepository->findOneBy(['name' => 'Hélios']));
                break;
                default:
                    switch ($luminary->getType()->getName()) {
                        case 'Etoile':
                            $luminary->setAround($this->luminaryRepository->findOneBy(['name' => 'Galade']));
                        break;
                        case 'Astéroïde':
                        case 'Comète':
                        case 'Géante gazeuse':
                        case 'Planète naine':
                        case 'Planète tellurique':
                            $luminary->setAround($star[random_int(0, count($star) - 1)]);
                        break;
                        case 'Satellite':
                        case 'Station Orbitale':
                            $luminary->setAround($planetoid[random_int(0, count($planetoid) - 1)]);
                        break;
                    }
                break;
            }
            /* 
            if ($luminary->getAround()) {
                echo '---->' . $luminary->getAround()->getType()->getName() . ' ' . $luminary->getAround()->getName() . PHP_EOL;
            } else {
                echo '---->N/A' . PHP_EOL;
            }
            */
            $manager->persist($luminary);
        }

        $manager->flush();

        return;
    }
}

<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comps;
use App\Entity\Caracs;
use App\Repository\CaracsRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PersoCompsFixtures extends Fixture
{
    /**
     * @var CaracsRepository
     */
    private $caracsRepository;

    /**
     * Constructor
     *
     * @param CaracsRepository  $caracsRepository
     */
    public function __construct(CaracsRepository $caracsRepository)
    {
        $this->caracsRepository = $caracsRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $usedCaracs = [];
            $nbCaracs = $this->getNbCaracs();
            $comp = (new Comps())
                ->setNom(substr($faker->sentence(1, true), 0, -1))
                ->setAbreviation('Ab' . ($i + 1))
                ->setDescription($faker->paragraph(3, true))
                ->setObsolete(false)
                ->setCaracPrimae($this->getRandomCarac())
                ->setValeur((1 == random_int(1, 50)) ? random_int(1, 10) * 10 : null)
                ->setType(random_int(1, 2))
            ;
            
            if (2 <= $nbCaracs) {
                $usedCaracs[] = $comp->getCaracPrimae()->getAbreviation();
                $comp->setCaracSecundae(($this->getRandomCarac($usedCaracs)));
            }
            
            if (3 <= $nbCaracs) {
                $usedCaracs[] = $comp->getCaracSecundae()->getAbreviation();
                $comp->setCaracTertiae(($this->getRandomCarac($usedCaracs)));
            }

            if (4 == $nbCaracs) {
                $usedCaracs[] = $comp->getCaracTertiae()->getAbreviation();
                $comp->setCaracQuartae(($this->getRandomCarac($usedCaracs)));
            }

            $manager->persist($comp);
        }

        $manager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOrder():int
    {
        return 1200;
    }

    /**
     * Get Nombre de caractéristiques
     *
     * @return int
     */
    private function getNbCaracs(): int
    {
        
        $n = random_int(1, 10);

        switch ($n) {
            case 1:
            case 2:
            case 3:
            case 4:
                $result = 1;
            break;
            case 5:
            case 6:
            case 7:
            case 8:
                $result = 2;
            break;
            case 9:
                $result = 3;
            break;
            case 10:
                $result = 4;
            break;
        }

        return $result;
    }

    /**
     * getRandomCarac
     *
     * @param array|null $usedCaracs
     * @return Caracs
     */
    private function getRandomCarac(?array $usedCaracs = []): ?Caracs
    {
        $caracs = ['AGI', 'CON', 'FOR', 'REF', 'PER', 'CHA', 'INT', 'LOG', 'VOL', 'SF'];
        $caracs = (!empty($usedCaracs))? array_values(array_diff($caracs, $usedCaracs)) : $caracs;
        $abrev = $caracs[random_int(0, count($caracs) - 1)];
        
        return $this->caracsRepository->findOneBy(['abreviation' => $abrev]);
    }
}

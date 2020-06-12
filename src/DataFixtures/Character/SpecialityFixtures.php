<?php
// src\DataFixtures\Character\SpecialityFixtures.php
namespace App\DataFixtures\Character;

use Faker\Factory;
use App\Entity\Character\Profession;
use App\Entity\Character\Speciality;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\Character\ProfessionRepository;

/**
 * Class SpecialityFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class SpecialityFixtures extends Fixture
{
    /**
     * @var ProfessionRepository
     */
    private $professionRepository;

    /**
     * SpecialityFixtures Constructor
     *
     * @param ProfessionRepository $professionRepository
     * 
     * @return void
     */
    public function __construct(ProfessionRepository $professionRepository)
    {
        $this->professionRepository = $professionRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listSpecialities = $this->getData();

        foreach ($listSpecialities as $s) {
            $profession = (new Speciality())
                ->setName($s['name'])
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
                ->setType($s['type'])
                ->setPlayable($s['playable'])
                ->setProfession($s['profession'])
            ;

            $manager->persist($profession);
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
     * Get data
     *
     * @return array
     */
    private function getData(): array
    {
        /**
         * @var Profession[]|null
         */
        $data = $this->professionRepository->findAll();
        
        foreach ($data as $value) {
            // Professions : 
            //      [x] Artilleur,  [x] Grenadier Voltigeur, [ ] Infirmier,  [x] Médecin,  
            //      [x] Technicien, [x] Tirailleur,          [x] Politicien, [x] Ingenieur, 
            //      [x] Rebelle
            $professions[$value->getName()] = $value;
        }
        
        return [
            [
                'name' => 'Terrorisme',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Rebelle']
            ],
            [
                'name' => 'Anarchie',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Rebelle']
            ],
            [
                'name' => 'Professeur',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Ingenieur']
            ],
            [
                'name' => 'Agronome',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Ingenieur']
            ],
            [
                'name' => 'Astro-physique',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Ingenieur']
            ],
            [
                'name' => 'Informatique',
                'type' => 3,
                'playable' => false,
                'profession' => $professions['Ingenieur']
            ],
            [
                'name' => 'Mécanique',
                'type' => 3,
                'playable' => false,
                'profession' => $professions['Ingenieur']
            ],
            [
                'name' => 'SkyMarshal',
                'type' => 3,
                'playable' => false,
                'profession' => $professions['Politicien']
            ],
            [
                'name' => 'Indépendance',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Politicien']
            ],
            [
                'name' => 'Senateur',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Politicien']
            ],
            [
                'name' => 'Gouverneur',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Politicien']
            ],
            [
                'name' => 'Maire',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Politicien']
            ],
            [
                'name' => 'Sniper',
                'type' => 1,
                'playable' => true,
                'profession' => $professions['Tirailleur']
            ],
            [
                'name' => 'Ranger',
                'type' => 1,
                'playable' => true,
                'profession' => $professions['Tirailleur']
            ],
            [
                'name' => 'Géologie',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Technicien']
            ],
            [
                'name' => 'Histore',
                'type' => 2,
                'playable' => false,
                'profession' => $professions['Technicien']
            ],
            [
                'name' => 'Logistique',
                'type' => 3,
                'playable' => false,
                'profession' => $professions['Technicien']
            ],
            [
                'name' => 'Informatique',
                'type' => 3,
                'playable' => true,
                'profession' => $professions['Technicien']
            ],
            [
                'name' => 'Mécanique',
                'type' => 3,
                'playable' => true,
                'profession' => $professions['Technicien']
            ],
            [
                'name' => 'Pièce légère',
                'type' => 1,
                'playable' => true,
                'profession' => $professions['Artilleur']
            ],
            [
                'name' => 'Pièce lourde',
                'type' => 1,
                'playable' => true,
                'profession' => $professions['Artilleur']
            ],
            [
                'name' => 'Commando',
                'type' => 1,
                'playable' => true,
                'profession' => $professions['Grenadier Voltigeur']
            ],
            [
                'name' => 'Généraliste',
                'type' => 3,
                'playable' => false,
                'profession' => $professions['Médecin']
            ],
            [
                'name' => 'Chirurgien',
                'type' => 3,
                'playable' => false,
                'profession' => $professions['Médecin']
            ],
            [
                'name' => 'Psychiatre',
                'type' => 3,
                'playable' => false,
                'profession' => $professions['Médecin']
            ],
        ];
    }
}

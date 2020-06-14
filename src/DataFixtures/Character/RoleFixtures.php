<?php
// src\DataFixtures\Character\RoleFixtures.php
namespace App\DataFixtures\Character;

use Faker\Factory;
use App\Entity\Character\Rank;
use App\Entity\Character\Role;
use App\Entity\Character\Accreditation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Character\RankFixtures;
use App\Repository\Character\RankRepository;
use App\Repository\Character\AccreditationRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class RoleFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class RoleFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var AccreditationRepository
     */
    private $accreditationRepository;

    /**
     * @var RankRepository
     */
    private $rankRepository;

    /**
     * RoleFixtures Constructor
     *
     * @param AccreditationRepository $accreditationRepository
     * @param RankRepository          $rankRepository
     * 
     * @return void
     */
    public function __construct(RankRepository $rankRepository, AccreditationRepository $accreditationRepository)
    {
        $this->accreditationRepository = $accreditationRepository;
        $this->rankRepository = $rankRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listRole = $this->getData();

        foreach ($listRole as $r) {
            $role = (new Role())
                ->setName($r['name'])
                ->setAbbreviation($r['abbreviation'])
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
                ->setDefault((isset($r['default'])) ? true : false)
                ->setPlayable((isset($r['playable'])) ? true : false)
                ->setType($r['type'])
                ->setRankMin($r['rankMin'])
                ->setRankMin((isset($r['rankMax'])) ? $r['rankMax'] : null)
                ->setAccreditationMin($r['accredMin'])
            ;
            
            $manager->persist($role);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RankFixtures::class,
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
         * @var Rank[]|null
         */
        $data = $this->rankRepository->findAll();
        
        foreach ($data as $value) {
            $rank[$value->getAbbreviation()] = $value;
        }
        
        /**
         * @var Accreditation[]|null
         */
        $data = $this->accreditationRepository->findAll();
    
        foreach ($data as $value) {
            $accreditations[$value->getAbbreviation()] = $value;
        }

        /* 
        Accréditations : 
            level 0 : Libre (AL)
            level 1 : Restreint (AR)
            level 2 : Confidentiel (AC), Confidentiel Défence (ACD), 
                Confidentiel Défence - Légion Fédérale (ACDL), 
                Confidentiel Défence - Infanterie Mobile (ACIM)
            level 3 : Confidentiel Défence - Sous-Officier (ACSO)
            level 4 : Confidentiel Défence - Officier (ACO), Régimentaire IV (AR-IV), 
                Confidentiel Médical III (M-III)
            level 5 : Régimentaire III (AR-III), Confidentiel Médical II (M-II)
            level 6 : Régimentaire II' (AR-II), Confidentiel Médical I (M-I)
            level 7 : Régimentaire I (AR-I), Confidentiel Fédéral II (ACF-II)',
            level 8 : Confidentiel Fédéral I (ACF-I)
        
        TYPE = 0: Not specified, 1: Military, 2: Civilian, 3: Mixte
        */

        return [
            [
                'name' => 'Commandant en chef de la Légion Fédérale',
                'abbreviation' => 'CCLF',
                'type' => 1,
                'playable' => false,
                'rankMin' => $rank['DGen'],
                'accredMin' => $accreditations['ACF-I']
            ],
            [
                'name' => 'Chef de Corps',
                'abbreviation' => 'CCR',
                'type' => 1,
                'rankMin' => $rank['Cmd'],
                'rankMax' => $rank['BGen'],
                'accredMin' => $accreditations['AR-I']
            ],
            [
                'name' => 'Commandant en Second du Régiment',
                'abbreviation' => 'CSR',
                'type' => 1,
                'rankMin' => $rank['Cpt'],
                'rankMax' => $rank['Col'],
                'accredMin' => $accreditations['AR-II']
            ],
            [
                'name' => 'Conseiller Millitaire & Technique',
                'abbreviation' => 'CMT',
                'type' => 3,
                'rankMin' => $rank['Sgt'],
                'accredMin' => $rank['Sgt']->getAccreditationMin()
            ],
            [
                'name' => 'Secretaire d\'Etat Major',
                'abbreviation' => 'SEM',
                'type' => 1,
                'rankMin' => $rank['Sgt'],
                'accredMin' => $accreditations['AR-III']
            ],
            [
                'name' => 'Directeur',
                'abbreviation' => 'DB',
                'type' => 3,
                'rankMin' => $rank['Maj'],
                'rankMax' => $rank['Col'],
                'accredMin' => $accreditations['AR-III']
            ],
            [
                'name' => 'Responsable de Service',
                'abbreviation' => 'RS',
                'type' => 3,
                'rankMin' => $rank['SCh'],
                'rankMax' => $rank['Cpt'],
                'accredMin' => $rank['SCh']->getAccreditationMin()
            ],
            [
                'name' => 'Primae Officier de Liaison',
                'abbreviation' => 'POL',
                'type' => 1,
                'rankMin' => $rank['Cpt'],
                'rankMax' => $rank['Col'],
                'accredMin' => $rank['Cpt']->getAccreditationMin()
            ],
            [
                'name' => 'Secondae Officier de Liaison',
                'abbreviation' => 'SOL',
                'type' => 1,
                'rankMin' => $rank['Lt'],
                'rankMax' => $rank['Col'],
                'accredMin' => $rank['Lt']->getAccreditationMin()
            ],
            [
                'name' => 'Officier de Liaison',
                'abbreviation' => 'OL',
                'type' => 1,
                'rankMin' => $rank['S/Lt'],
                'rankMax' => $rank['Col'],
                'accredMin' => $rank['S/Lt']->getAccreditationMin()
            ],
            [
                'name' => 'Officier de Liaison Stagiaire',
                'abbreviation' => 'OLS',
                'type' => 1,
                'rankMin' => $rank['Asp'],
                'rankMax' => $rank['Lt'],
                'accredMin' => $rank['Asp']->getAccreditationMin()
            ],
            [
                'name' => 'Commissaire Directeur',
                'abbreviation' => 'COD',
                'type' => 1,
                'playable' => false,
                'rankMin' => $rank['Lt Col'],
                'accredMin' => $accreditations['ACF-I']
            ],
            [
                'name' => 'Commissaire Directeur Adjoint',
                'abbreviation' => 'CDA',
                'type' => 1,
                'playable' => false,
                'rankMin' => $rank['Cmd'],
                'accredMin' => $accreditations['ACF-I']
            ],
            [
                'name' => 'Primae Commissaire',
                'abbreviation' => 'PCO',
                'type' => 1,
                'rankMin' => $rank['Cpt'],
                'accredMin' => $accreditations['AR-I']
            ],
            [
                'name' => 'Secondae Commissaire',
                'abbreviation' => 'SCO',
                'type' => 1,
                'rankMin' => $rank['Lt'],
                'accredMin' => $accreditations['AR-I']
            ],
            [
                'name' => 'Commissaire',
                'abbreviation' => 'CO',
                'type' => 1,
                'rankMin' => $rank['S/Lt'],
                'accredMin' => $accreditations['AR-II']
            ],
            [
                'name' => 'Commissaire Stagiaire',
                'abbreviation' => 'COS',
                'type' => 1,
                'rankMin' => $rank['Asp'],
                'accredMin' => $accreditations['AR-III']
            ],
            [
                'name' => 'Primae Archiviste',
                'abbreviation' => 'PAR',
                'type' => 1,
                'rankMin' => $rank['SCh'],
                'accredMin' => $accreditations['AR-IV']
            ],
            [
                'name' => 'Secondae Archiviste',
                'abbreviation' => 'SAR',
                'type' => 1,
                'rankMin' => $rank['Sgt'],
                'accredMin' => $rank['Sgt']->getAccreditationMin()
            ],
            [
                'name' => 'Archiviste',
                'abbreviation' => 'AR',
                'type' => 1,
                'rankMin' => $rank['Cpl'],
                'accredMin' => $rank['Cpl']->getAccreditationMin()
            ],
            [
                'name' => 'Directeur de l\'Infirmerie',
                'abbreviation' => 'DI',
                'type' => 1,
                'rankMin' => $rank['Cmd'],
                'accredMin' => $accreditations['M-I']
            ],
            [
                'name' => 'Medecin Chef',
                'abbreviation' => 'MC',
                'type' => 1,
                'rankMin' => $rank['Lt'],
                'accredMin' => $accreditations['M-II']
            ],
            [
                'name' => 'Directeur des soins',
                'abbreviation' => 'DS',
                'type' => 1,
                'rankMin' => $rank['Adj'],
                'accredMin' => $accreditations['M-III']
            ],
            [
                'name' => 'Officier',
                'abbreviation' => 'OFF',
                'type' => 1,
                'rankMin' => $rank['Asp'],
                'rankMax' => $rank['Col'],
                'accredMin' => $rank['Asp']->getAccreditationMin()
            ],
            [
                'name' => 'Sous-officier',
                'abbreviation' => 'SSO',
                'type' => 1,
                'rankMin' => $rank['Sgt'],
                'rankMax' => $rank['Maj'],
                'accredMin' => $rank['Sgt']->getAccreditationMin()
            ],
            [
                'name' => 'Homme du Rang',
                'abbreviation' => 'HR',
                'type' => 1,
                'rankMin' => $rank['2cl'],
                'rankMax' => $rank['CCh'],
                'accredMin' => $rank['2cl']->getAccreditationMin()
            ],
            [
                'name' => 'Redacteur en Chef',
                'abbreviation' => 'RC',
                'type' => 1,
                'rankMin' => $rank['Sgt'],
                'accredMin' => $rank['Sgt']->getAccreditationMin()
            ],
            [
                'name' => 'Commandant de Compagnie',
                'abbreviation' => 'CC',
                'type' => 1,
                'rankMin' => $rank['S/Lt'],
                'accredMin' => $accreditations['AR-IV']
            ],
            [
                'name' => 'Commandant en Second de Compagnie',
                'abbreviation' => 'CSC',
                'type' => 1,
                'rankMin' => $rank['Maj'],
                'accredMin' => $accreditations['ACO']
            ],
            [
                'name' => 'Chef de Peloton',
                'abbreviation' => 'CPE',
                'type' => 1,
                'rankMin' => $rank['Sgt'],
                'accredMin' => $accreditations['ACSO']
            ],
            [
                'name' => 'Chef d\'Escouade',
                'abbreviation' => 'CES',
                'type' => 1,
                'rankMin' => $rank['Cpl'],
                'accredMin' => $accreditations['ACDL']
            ],
        ];
    }
}

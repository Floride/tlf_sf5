<?php
// src\DataFixtures\Game\AffectationFixtures.php
namespace App\DataFixtures\Game;

use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Game\Affectation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Repository\Game\AffectationRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class AffectationFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class AffectationFixtures extends Fixture
{
    /**
     * @var AffectationRepository
     */
    private $affectationRepository;

    /**
     * SpecalityFixtures Constructor
     *
     * @param AffectationRepository $affectationRepository
     * 
     * @return void
     */
    public function __construct(AffectationRepository $affectationRepository)
    {
        $this->affectationRepository = $affectationRepository;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listAffectation = $this->getData();

        foreach ($listAffectation as $a) {
            $affectation = (new Affectation())
                ->setName($a['name'])
                ->setAbbreviation($a['abbreviation'])
                ->setDescription($faker->paragraph(5, true))
                ->setObsolete(false)
                ->setDefault((isset($r['default'])) ? true : false)
                ->setType($a['type'])
            ;
            
            $manager->persist($affectation);
        }

        $manager->flush();

        $this->Updateparent($listAffectation, $manager);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder():int
    {
        return 1100;
    }
    
    /**
     * Get data
     *
     * @return array
     */
    private function getData(): array
    {
        $affectations = [
            [
                'name' => 'Fédération',
                'abbreviation' => 'FED',
                'type' => 3,
                'default' => true
            ],
            [
                'name' => 'Sénat Fédérale',
                'abbreviation' => 'FEDSEN',
                'type' => 2,
                'parent' => 'FED'
            ],
            [
                'name' => 'Etat-Major des Armées',
                'abbreviation' => 'EMA',
                'type' => 2,
                'parent' => 'FED'
            ],
            [
                'name' => 'Infanterie Mobile',
                'abbreviation' => 'IM',
                'type' => 3,
                'parent' => 'EMA'
            ],
            [
                'name' => 'Etat-Major de l\'Infanterie Mobile',
                'abbreviation' => 'IMEM',
                'type' => 2,
                'parent' => 'IM'
            ],
            [
                'name' => 'Légion Férérale',
                'abbreviation' => 'LEFE',
                'type' => 3,
                'parent' => 'IMEM'
            ],
            [
                'name' => 'Etat-Major de la Légion Férérale',
                'abbreviation' => 'EMLEFE',
                'type' => 2,
                'parent' => 'LEFE'
            ],
            [
                'name' => 'Commissariat Férérale',
                'abbreviation' => 'COF',
                'type' => 2,
                'parent' => 'FEDSEN'
            ],
            [
                'name' => 'Commissariat Régimentaire',
                'abbreviation' => 'COR228RLF',
                'type' => 2,
                'parent' => 'COF'
            ],
            [
                'name' => 'Centre de Recrutement de la Légion Fédérale',
                'abbreviation' => 'CRLF',
                'type' => 2,
                'parent' => 'EMLEFE'
            ],
            [
                'name' => 'Académie',
                'abbreviation' => 'ALF',
                'type' => 2,
                'parent' => 'EMLEFE'
            ],
            [
                'name' => '228ème Régiment de la Légion Fédérale (228e R.L.F)',
                'abbreviation' => '228RLF',
                'type' => 3,
                'parent' => 'EMLEFE'
            ],
            [
                'name' => 'Etat-Major',
                'abbreviation' => '228RLF-EM',
                'type' => 2,
                'parent' => '228RLF'
            ],
            [
                'name' => 'Compagnie d\'instruction',
                'abbreviation' => '228RLF-CI',
                'type' => 1,
                'parent' => '228RLF-EM'
            ],
            [
                'name' => 'Bureau Médicale',
                'abbreviation' => '228RLF-BM',
                'type' => 2,
                'parent' => '228RLF-EM'
            ],
            [
                'name' => 'Service Infirmerie',
                'abbreviation' => '228RLF-BMI',
                'type' => 2,
                'parent' => '228RLF-BM'
            ],
            [
                'name' => 'Bureau Administratif',
                'abbreviation' => '228RLF-BAM',
                'type' => 2,
                'parent' => '228RLF-EM'
            ],
            [
                'name' => 'Service Missions',
                'abbreviation' => '228RLF-BAMMI',
                'type' => 2,
                'parent' => '228RLF-BAM'
            ],
            [
                'name' => 'Service Equiments',
                'abbreviation' => '228RLF-BAME',
                'type' => 2,
                'parent' => '228RLF-BAM'
            ],
            [
                'name' => 'Service Armurerie',
                'abbreviation' => '228RLF-BAMA',
                'type' => 2,
                'parent' => '228RLF-BAM'
            ],
        ];

        for ($c = 1; $c < 10; $c++) {
            $affectations[] = [
                'name' => $c . (($c == 1) ? 'ère' : 'ème') . ' Compagnie',
                'abbreviation' => '228RLF-C'.  $c,
                'type' => 3,
                'parent' => '228RLF-EM'
            ];
            $affectations[] = [
                'name' => 'Etat Major de la ' . $c . (($c == 1) ? 'ère' : 'ème') . ' Compagnie',
                'abbreviation' => '228RLF-C'.  $c . '-EM',
                'type' => 2,
                'parent' => '228RLF-C'.  $c
            ];
            
            for ($p = 1; $p < 4; $p++) {
                $affectations[] = [
                    'name' => $p . (($p == 1) ? 'er' : 'ème') . ' Peloton',
                    'abbreviation' => '228RLF-C'. $c . 'P' . $p,
                    'type' => 3,
                    'parent' => '228RLF-C'.  $c . '-EM',
                ];
                $affectations[] = [
                    'name' => 'Etat Major du ' . $p . (($c == 1) ? 'er' : 'ème') . ' Peloton',
                    'abbreviation' => '228RLF-C'. $c . 'P' . $p .'-EM',
                    'type' => 2,
                    'parent' => '228RLF-C'. $c . 'P' . $p,
                ];
                
                for ($e = 1; $e < 4; $e++) {
                    $affectations[] = [
                        'name' => $e . (($e == 1) ? 'ère' : 'ème') . ' Escouade',
                        'abbreviation' => '228RLF-C'. $c . 'P' . $p . 'E' . $e,
                        'type' => 1,
                        'parent' => '228RLF-C'. $c . 'P' . $p .'-EM',
                    ];
                }
            }
        }

        return $affectations;
    }

    /**
     * Updateparent
     *
     * @param array         $affectations
     * @param ObjectManager $manager
     * 
     * @return void
     */
    private function Updateparent(array $listAffectations, ObjectManager $manager): void
    {
        /**
         * @var Affectation[]|null
         */
        $affectations = $this->affectationRepository->findAll();

        foreach ($listAffectations as $a) {
            foreach ($affectations as $affectation) {
                if ($a['abbreviation'] == $affectation->getAbbreviation()) {
                    if (isset($a['parent']) && !is_null($a['parent'])) {
                        $parent = $this->affectationRepository->findOneBy(['abbreviation' => $a['parent']]);
                        $affectation->setparent($parent);

                        $manager->persist($affectation);
                    }
                    break;
                }
            }
        }

        $manager->flush();
    }
}

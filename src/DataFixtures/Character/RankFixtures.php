<?php
// src\DataFixtures\Character\RankFixtures.php
namespace App\DataFixtures\Character;

use Faker\Factory;
use App\Entity\Character\Rank;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class RankFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class RankFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $listRanks = $this->getData();

        foreach($listRanks as $r) {
            $rank = (new Rank())
                ->setName($r['name'])
                ->setAbbreviation($r['abbreviation'])
                ->setDescription($faker->paragraph(5, true))
                ->setCategory($r['category'])
                ->setObsolete(false)
                ->setType($r['type'])
                ->setPlayable((isset($r['playable']) && !$r['playable']) ? false : true)
                ->setDefault((isset($r['default'])) ? true : false)
                ->setScore($r['score'])
                ->setScoreOL((isset($r['scoreOL'])) ? $r['scoreOL'] : null)
            ;

            $manager->persist($rank);
        }

        $manager->flush();
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
        $ptsGrd = 10;
        return [
            [
                'name' => 'SkyMarchal',
                'abbreviation' => 'Sky',
                'type' => 1,
                'playable' => false,
                'score' => 80 * 12 * $ptsGrd,
                'scoreOL' => 72 * 12 * $ptsGrd,
                'category' => 4
            ],
            [
                'name' => 'Général d\'armée',
                'abbreviation' => 'AGen',
                'type' => 1,
                'playable' => false,
                'score' => 60 * 12 * $ptsGrd,
                'scoreOL' => 60 * 12 * $ptsGrd,
                'category' => 4
            ],
            [
                'name' => 'Général de corps d\'armée',
                'abbreviation' => 'CAGen',
                'type' => 1,
                'playable' => false,
                'score' => 50 * 12 * $ptsGrd,
                'scoreOL' => 48 * 12 * $ptsGrd,
                'category' => 4
            ],
            [
                'name' => 'Général de division',
                'abbreviation' => 'DGen',
                'type' => 1,
                'playable' => false,
                'score' => 40 * 12 * $ptsGrd,
                'scoreOL' => 24 * 12 * $ptsGrd,
                'category' => 4
            ],
            [
                'name' => 'Général de brigade',
                'abbreviation' => 'BGen',
                'type' => 1,
                'playable' => false,
                'score' => 30 * 12 * $ptsGrd,
                'scoreOL' => 16 * 12 * $ptsGrd,
                'category' => 4
            ],
            [
                'name' => 'Colonel',
                'abbreviation' => 'Col',
                'type' => 1,
                'playable' => false,
                'score' => 25 * 12 * $ptsGrd,
                'scoreOL' => 12 * 12 * $ptsGrd,
                'category' => 3
            ],
            [
                'name' => 'Lieutenant-Colonel',
                'abbreviation' => 'Lt Col',
                'type' => 1,
                'score' => 25 * 12 * $ptsGrd,
                'scoreOL' => 8 * 12 * $ptsGrd,
                'category' => 3
            ],
            [
                'name' => 'Commandant',
                'abbreviation' => 'Cmd',
                'type' => 1,
                'score' => 20 * 12 * $ptsGrd,
                'scoreOL' => 4 * 12 * $ptsGrd,
                'category' => 3
            ],
            [
                'name' => 'Capitaine',
                'abbreviation' => 'Cpt',
                'type' => 1,
                'score' => 17 * 12 * $ptsGrd,
                'scoreOL' => 2 * 12 * $ptsGrd,
                'category' => 3
            ],
            [
                'name' => 'Lieutenant',
                'abbreviation' => 'Lt',
                'type' => 1,
                'score' => 14 * 12 * $ptsGrd,
                'scoreOL' => 1 * 12 * $ptsGrd,
                'category' => 3
            ],
            [
                'name' => 'Sous-Lieutenant',
                'abbreviation' => 'S/Lt',
                'type' => 1,
                'score' => 11 * 12 * $ptsGrd,
                'scoreOL' => 0.5 * 12 * $ptsGrd,
                'category' => 3
            ],
            [
                'name' => 'Aspirant',
                'abbreviation' => 'Asp',
                'type' => 1,
                'score' => 0,
                'scoreOL' => 0,
                'category' => 3
            ],
            [
                'name' => 'Major',
                'abbreviation' => 'Maj',
                'type' => 1,
                'score' => 10 * 12 * $ptsGrd,
                'category' => 2
            ],
            [
                'name' => 'Adjudant-chef',
                'abbreviation' => 'AdC',
                'type' => 1,
                'score' => 7 * 12 * $ptsGrd,
                'category' => 2
            ],
            [
                'name' => 'Adjudant',
                'abbreviation' => 'Adj',
                'type' => 1,
                'score' => 5 * 12 * $ptsGrd,
                'category' => 2
            ],
            [
                'name' => 'Sergent-Chef',
                'abbreviation' => 'SCh',
                'type' => 1,
                'score' => 3 * 12 * $ptsGrd,
                'category' => 2
            ],
            [
                'name' => 'Sergent',
                'abbreviation' => 'Sgt',
                'type' => 1,
                'score' => 1.5 * 12 * $ptsGrd,
                'category' => 2
            ],
            [
                'name' => 'Caporal-Chef',
                'abbreviation' => 'CCh',
                'type' => 1,
                'score' => 12 * $ptsGrd,
                'category' => 1
            ],
            [
                'name' => 'Caporal',
                'abbreviation' => 'Cpl',
                'type' => 1,
                'score' => 6 * $ptsGrd,
                'category' => 1
            ],
            [
                'name' => 'Soldat de 1ère Classe',
                'abbreviation' => '1cl',
                'type' => 1,
                'score' => 2 * $ptsGrd,
                'category' => 1
            ],
            [
                'name' => 'Soldat de 2ème Classe',
                'abbreviation' => '2cl',
                'type' => 1,
                'score' => 0,
                'category' => 1
            ],
            [
                'name' => 'Cadet de 1ère Classe',
                'abbreviation' => 'C1cl',
                'type' => 1,
                'score' => 0,
                'scoreOL' => 0,
                'category' => 5
            ],
            [
                'name' => 'Cadet de 2ème Classe',
                'abbreviation' => 'C2cl',
                'type' => 1,
                'score' => 0,
                'category' => 5
            ],
            [
                'name' => 'Cadet de 3ème Classe',
                'abbreviation' => 'C3cl',
                'type' => 1,
                'score' => 0,
                'category' => 5
            ],
            [
                'name' => 'Cadet de 4ème Classe',
                'abbreviation' => 'C4cl',
                'type' => 1,
                'score' => 0,
                'category' => 5
            ],
            [
                'name' => 'Citoyen',
                'abbreviation' => 'CIT',
                'type' => 2,
                'playable' => false,
                'score' => 20 * 12 * $ptsGrd,
                'category' => 0
            ],
            [
                'name' => 'Civil',
                'abbreviation' => 'CIV',
                'type' => 2,
                'playable' => false,
                'default' => true,
                'score' => 0,
                'category' => 0
            ],
        ];
    }
}
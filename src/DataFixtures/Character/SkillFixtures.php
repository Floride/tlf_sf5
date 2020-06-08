<?php
// src\DataFixtures\Character\SkillFixtures.php
namespace App\DataFixtures\Character;

use App\Entity\Character\Skill;
use App\Entity\Character\Feature;
use App\Repository\Character\FeatureRepository;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class SkillFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class SkillFixtures extends Fixture
{
    /**
     * @var FeatureRepository
     */
    private $featureRepository;

    /**
     * Constructor
     *
     * @param FeatureRepository  $featureRepository
     * 
     * @return void
     */
    public function __construct(FeatureRepository $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $usedFeatures = [];
            $nbFeatures = $this->getNbFeature();
            $skill = (new Skill())
                ->setName(substr($faker->sentence(1, true), 0, -1) . ' ' . uniqid())
                ->setAbbreviation('Ab' . ($i + 1))
                ->setDescription($faker->paragraph(3, true))
                ->setObsolete(false)
                ->setFeaturePrimae($this->getRandomFeature())
                ->setValue((1 == random_int(1, 50)) ? random_int(1, 10) * 10 : null)
                ->setType(random_int(1, 2))
            ;
            
            if (2 <= $nbFeatures) {
                $usedFeatures[] = $skill->getFeaturePrimae()->getAbbreviation();
                $skill->setFeatureSecundae(($this->getRandomFeature($usedFeatures)));
            }
            
            if (3 <= $nbFeatures) {
                $usedFeatures[] = $skill->getFeatureSecundae()->getAbbreviation();
                $skill->setFeatureTertiae(($this->getRandomFeature($usedFeatures)));
            }

            if (4 == $nbFeatures) {
                $usedFeatures[] = $skill->getFeatureTertiae()->getAbbreviation();
                $skill->setFeatureQuartae(($this->getRandomFeature($usedFeatures)));
            }

            $manager->persist($skill);
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
     * getNbFeature
     *
     * @return int
     */
    private function getNbFeature(): int
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
     * getRandomFeature
     *
     * @param array|null $usedFeatures
     * @return Feature
     */
    private function getRandomFeature(?array $usedFeatures = []): ?Feature
    {
        // TODO : Ajouter dynamiquement la list des abréviations en fonction de la bdd
        $features = ['AGI', 'CON', 'FOR', 'REF', 'PER', 'CHA', 'INT', 'LOG', 'VOL', 'SF'];
        $features = (!empty($usedFeatures)) ? array_values(array_diff($features, $usedFeatures)) : $features;
        $abbrev = $features[random_int(0, count($features) - 1)];
        
        return $this->featureRepository->findOneBy(['abbreviation' => $abbrev]);
    }
}

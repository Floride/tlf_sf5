<?php
// src\DataFixtures\Character\FeatureFixtures.php
namespace App\DataFixtures\Character;

use App\Entity\Character\Feature;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class FeatureFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class FeatureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $listFeatures = $this->getData();

        foreach ($listFeatures as $element) {
            $feature = (new Feature()) // On crée une caractéristique
                ->setName($element['name']) // On ajoute le nom
                ->setAbbreviation($element['abbreviation']) // On ajoute l'abréviation
                ->setValueMin($element['valueMin']) // On ajoute la value min
                ->setValueMax($element['valueMax']) // On ajoute la value max
                ->setValueAverage($element['valueAverage']) // On ajoute la value moyenne
                ->setDescription($element['description']) // On ajoute la description
                ->setType($element['type']) // On ajoute le type
                ->setObsolete(false) // Pas obsolète
            ;

            $manager->persist($feature);
        }

        $manager->flush();

        return;
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
        return [
            [
                'name' => 'Agilité', 'abbreviation' => 'AGI',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 1,
                'description' => 'Cette caractéristique représente les réflexes moteurs, la dextérité manuelle, la souplesse, l\'équilibre et la coordination.
Un personnage qui a une Agilité faible a peut-ptre un problème d\'oreille interne, une jambe plus courte que l\'autre, ou est simplement empoté. Les indicices élevés d\'Agilité peuvent se trouve chez les personnages qui sont athlétique "de nature".'
            ],
            [
                'name' => 'Constitution', 'abbreviation' => 'CON',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 1,
                'description' => 'Cette caratéristique détermine la résistance du personnage face facteur externe. Représente l\'endurance, la capacité cardio-vasculaire, sont système immunitaire, ses facultés de cicatrisation et de guerrison, sa tolérance aux poisons/drogues/toxiques, sa structure musculaire et ossueuse ainsi que son poid. Une consitution faible peut signifier que le personnage est maigre, chétif, qu\'il a de mauvaise habitude alimentaire ou sanitaire, ou qu\'il sort de maladie ou d\'une grosse opération.
Une value de Constitution élévée signfie que le personnage est bien alimenté, solide comme un roc, possède des os résistants et un système immunitaire fiable. Une value de Constitution élévée n\'est pas une garantie de taille élevée mais s\'est souvent le cas.'
            ],
            [
                'name' => 'Force', 'abbreviation' => 'FOR',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 1,
                'description' => 'Cette caractéristique couvre tout ce qu\'un personnage est capable de faire en faisant appel à ses muscles, à soulever ou à courrir vite. Elle dépend de taille et de la race de personnage.
Un personnage doté d\'une grande force est solide et vigoureux, tire au maximum parti de son corps, fait de l\'exercice quotidiennement.'
            ],
            [
                'name' => 'Reflexe', 'abbreviation' => 'REF',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 1,
                'description' => 'Cette caractéristique représente les réflexes physique d\'une personnage : sa vitesse de réaction sous la pression des évènements, comment il peut éviter les projectils et les coups. Un personnage doté d\'un indice élevé de Réflexe a plus de chance de dominer une situation, sera en meilleur posture pour réagir face au danger.'
            ],
            [
                'name' => 'Perception', 'abbreviation' => 'PER',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 1,
                'description' => 'Cette caractéristique représente la capacité d\'un personnage à appréhender son environnement. La vue, l\'ouie, l\'odorat, le touché et le goût sont lié à la caractéristique de perception.'
            ],
            [
                'name' => 'Charisme', 'abbreviation' => 'CHA',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 2,
                'description' => 'Le Charisme repésente l\'aura personnelle du personnage, sa confiance en lui, son ego, sa facilité à déceler les attentes des gens et à y repondre ainsi que sa capacité à tirer le meilleur de quelqu\'un ou à savoir ce qu\'il vaut mieux éviter de lui demander.
Un personnage geignard, une attitude de "moi je" ou une incapacité à lire le langage non-verbal ou saisir certaines subtilités sont des exemplesde ce qui peut traduire une value de Charisme vraisemblablemnt basse.
À l\'inverse une indice élevé se traduira pour un comportement tourné vers autrui, une personne appréciant de divertir les autres, excellant dansl\'art de nouer de nouvelle relation/amitié et/ou de manipuler les autres à sa guise ou encore avoir un bon sens de la répartie en toute ciconstance.
C\'est la caractéristique principale des personnages "qui assurent", imposent "naturellement" le respect et ont un côté "sexy" qui ne s\'explique pas.'
            ],
            [
                'name' => 'Intuition', 'abbreviation' => 'INT',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 2,
                'description' => 'Cette caractéristique est la capacité d\'un personnage à traiter des informations, à percevoir des mouvements de foule, à évaluer le danger ou l\'opportunité d\'une situation. C\'est une forme d\'instinct qui, si l\'indice est élevé permet de "sentir les choses" et s\'il est faible donne le sentiment que le personnage est inattentif ou analyse rarement les choses en profondeur ou est symplement "lent".'
            ],
            [
                'name' => 'Logique', 'abbreviation' => 'LOG',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 2,
                'description' => 'Cette caractéristique représente la capacité intellectuelle et de mémorisation du personnage. Elle donne une value à la capacité et la vitesse d\'apprentissage, sa capacité à se souvenir de détails ou exécuter des tâches de mémoire.'
            ],
            [
                'name' => 'Volonté', 'abbreviation' => 'VOL',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 2,
                'description' => 'Cette caractéristique est un indicateur de la capacité du personnage à continuer alors qu\'il voudrait abandonné. Un personnage avec une faible volonté se repose sur les autres lorsque un décision importante doit être prise. A l\'opposé, un personnage avec un forte value en volonté aura de l\'assurance et tendance à ne pas à ne jamais abandonner ni désespérer. C\'est aussi la capacité qui permet au personnage de résister à la manipulation, par exemple.'
            ],
            [
                'name' => 'Sang Froid', 'abbreviation' => 'SF',
                'valueMin' => 20, 'valueMax' => 100, 'valueAverage' => 40, 'type' => 2,
                'description' => 'Capacité d\'un personnage a se maitriser et garder le contrôle, même sous le feu ennemi. C\'est la capacité qui permet au personnage de résister à l\'intimidation.'
            ],
        ];
    }
}

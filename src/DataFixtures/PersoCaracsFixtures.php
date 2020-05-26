<?php

namespace App\DataFixtures;

use App\Entity\Caracs;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PersoCaracsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $caracs = [
            [
                'nom' => 'Agilité', 'abrev' => 'AGI',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 1,
                'description' => '[Caractéristique Physique]
                    Cette caractéristique représente les réflexes moteurs, la dextérité manuelle, la souplesse, l\'équilibre et la coordination.
                    Un personnage qui a une Agilité faible a peut-ptre un problème d\'oreille interne, une jambe plus courte que l\'autre,
                    ou est simplement empoté. Les indicices élevés d\'Agilité peuvent se trouve chez les personnages qui sont athlétique "de nature".'
            ],
            [
                'nom' => 'Constitution', 'abrev' => 'CON',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 1,
                'description' => '[Caractéristique Physique]
                    Cette caratéristique détermine la résistance du personnage face facteur externe. Représente l\'endurance, la capacité cardio-vasculaire,
                    sont système immunitaire, ses facultés de cicatrisation et de guerrison, sa tolérance aux poisons/drogues/toxiques, sa structure musculaire
                    et ossueuse ainsi que son poid. Une consitution faible peut signifier que le personnage est maigre, chétif, qu\'il a de mauvaise habitude
                    alimentaire ou sanitaire, ou qu\'il sort de maladie ou d\'une grosse opération.
                    Une valeur de Constitution élévée signfie que le personnage est bien alimenté, solide comme un roc, possède des os résistants et un système
                    immunitaire fiable. Une valeur de Constitution élévée n\'est pas une garantie de taille élevée mais s\'est souvent le cas.'
            ],
            [
                'nom' => 'Force', 'abrev' => 'FOR',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 1,
                'description' => '[Caractéristique Physique]
                    Cette caractéristique couvre tout ce qu\'un personnage est capable de faire en faisant appel à ses muscles, à soulever ou à courrir vite.
                    Elle dépend de taille et de la race de personnage.
                    Un personnage doté d\'une grande force est solide et vigoureux, tire au maximum parti de son corps, fait de l\'exercice quotidiennement.'
            ],
            [
                'nom' => 'Reflexe', 'abrev' => 'REF',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 1,
                'description' => '[Caractéristique Physique]
                    Cette caractéristique représente les réflexes physique d\'une personnage : sa vitesse de réaction sous la pression des évènements, comment il
                    peut éviter les projectils et les coups. Un personnage doté d\'un indic élevé de Réflexe a plus de chance de dominer une situation, sera en
                    meilleur posture pour réagir face au danger.'
            ],
            [
                'nom' => 'Perception', 'abrev' => 'PER',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 1,
                'description' => '[Caractéristique Mentale]
                    Cette caractéristique représente la capacité d\'un personnage à appréhender son environnement. La vue, l\'ouie, l\'odorat, le touché et le goût
                    sont lié à la caractéristique de perception.'
            ],
            [
                'nom' => 'Charisme', 'abrev' => 'CHA',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 2,
                'description' => '[Caractéristique Mentale]
                    Le Charisme repésente l\'aura personnel du personnage, sa confiance en lui, son ego, sa facilité à déceler les attentes des gens et à y repondre
                    ainsi que sa capacité à tirer le meilleur de quelqu\'un ou à savoir ce qu\'il vaut mieux éviter de lui demander.
                    Un personnage geignard, une attitude de "moi je" ou une incapacité à lire le language non-verbal ou saisir certaines subtilités sont des exemples
                    de ce qui peut traduire une valeur de Charisme vraisemblablemnt basse.
                    A l\'invers une indice élevé se traduira pour un comportement tourné vers autrui, une personne appréciant de divertir les autres, excellant dans
                    l\'art de nouer de nouvelle relation/amitié et/ou de manipuler les autres à sa guise ou encore avoir un bon sens de la répartie en toute ciconstance.
                    C\'est la caractéristique principale des personnages "qui assurent", imposent "naturellement" le respect et ont un côté "sexy" qui ne s\'explique pas.'
            ],
            [
                'nom' => 'Intuition', 'abrev' => 'INT',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 2,
                'description' => '[Caractéristique Mentale]
                    Cette caractéristique est la capacité d\'un personnage à traiter des informations, à percevoir des mouvements de foule, à évaluer le danger ou 
                    l\'opportunité d\'une situation. C\'est une forme d\'instinct qui, si l\'indice est élevé permet de "sentir les choses" et s\'il est faible 
                    donne le sentiment que le personnage est inattentif ou analyse rarement les choses en profondeur ou est symplement "lent".'
            ],
            [
                'nom' => 'Logique', 'abrev' => 'LOG',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 2,
                'description' => '[Caractéristique Mentale]
                    Cette caractéristique représente la capacité intellectuelle et de mémorisation du personnage. Elle donne une valeur à la capacité et la vitesse
                    d\'apprentissage, sa capacité à se souvenir de détails ou exécuter des tâches de mémoire.'
            ],
            [
                'nom' => 'Volonté', 'abrev' => 'VOL',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 2,
                'description' => '[Caractéristique Mentale]
                    Cette caractéristique est un indicateur de la capacité du personnage à continuer alors qu\'il voudrait abandonné. Un personnage avec une faible volonté
                    se repose sur les autres lorsque un décision importante doit être prise. A l\'opposé, un personnage avec un forte valeur en volonté aura de l\'assurance
                    et tendance à ne pas à ne jamais abandonner ni désespérer. C\'est aussi la capacité qui permet au personnage de résister à la manipulation, par exemple.'
            ],
            [
                'nom' => 'Sang Froid', 'abrev' => 'SF',
                'valeurMin' => 20, 'valeurMax' => 100, 'valeurMoy' => 40, 'type' => 2,
                'description' => '[Caractéristique Mentale]
                    Capacité d\'un personnage a se maitriser et garder le contrôle, même sous le feu ennemi. C\'est la capacité qui permet au personnage de résister à l\'intimidation.'
            ],
        ];

        foreach ($caracs as $carac) {
            $c = (new Caracs())  // On crée une caractéristique
                ->setNom($carac['nom'])                 // On ajoute la clé
                ->setAbreviation($carac['abrev'])      // On ajoute l'abréviation
                ->setValeurMin($carac['valeurMin'])     // On ajoute la valeur min
                ->setValeurMax($carac['valeurMax'])     // On ajoute la valeur max
                ->setValeurMoyenne($carac['valeurMoy']) // On ajoute la valeur moy
                ->setDescription($carac['description']) // On ajoute la description
                ->setType($carac['type'])               // On ajoute le type
            ;

            $manager->persist($c);
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
}

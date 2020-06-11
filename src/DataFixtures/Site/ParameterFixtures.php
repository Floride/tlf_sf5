<?php
// src\DataFixtures\Site\ParameterFixtures.php
namespace App\DataFixtures\Site;

use App\Entity\Site\Parameter;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class ParameterFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.3
 */
class ParameterFixtures extends Fixture
{
    /**
     * Load
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $listParameters = $this->getData();

        foreach ($listParameters as $p) {
            $Parameter = (new Parameter()) // On crée un paramètre
                ->setName($p['name']) // On la clé
                ->setValue($p['value']) // On la value
            ;

            $manager->persist($Parameter);
        }

        $manager->flush();

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder():int
    {
        return 1000;
    }

    /**
     * Get data
     *
     * @return array
     */
    private function getData(): array
    {
        return [
            ['name' => 'annee_debut', 'value' => '2440'],
            ['name' => 'regiment_nom', 'value' => '228ème Régiment de la Légion Fédérale'],
            ['name' => 'regiment_abbr', 'value' => '228e R.L.F.'],
            ['name' => 'presentation', 'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
Pellentesque convallis lacinia pellentesque. Cras gravida, neque sed lacinia malesuada, arcu tellus commodo magna, sed tempor nisl tellus eget mi. Suspendisse at pulvinar nulla. In condimentum imperdiet velit a pellentesque. Proin enim ligula, eleifend eu ligula volutpat, posuere scelerisque orci. Proin congue id tortor nec gravida. Fusce rhoncus interdum sapien id auctor. Aliquam diam arcu, sagittis non ipsum eu, convallis volutpat risus. Nam auctor, risus a suscipit imperdiet, nibh urna sollicitudin justo, sit amet aliquet ipsum enim sit amet sem. Proin mi arcu, cursus vitae purus sed, malesuada luctus nulla. Etiam at justo at neque efficitur rutrum. Vestibulum a augue purus.
Donec gravida nunc dui, non accumsan leo rhoncus et. Suspendisse pellentesque feugiat magna, ut mollis justo dignissim at. Ut sit amet tempus arcu, at volutpat libero. Etiam libero dui, eleifend ut ligula sit amet, elementum interdum mauris. Nulla viverra ante eget maximus maximus. Etiam ex metus, fringilla ac pharetra et, dignissim eget urna. Etiam maximus ornare ex eget lacinia. Aliquam vel mauris eget mi semper pellentesque sit amet a augue. Proin auctor mollis dolor nec auctor. Curabitur eget diam ut felis mattis sollicitudin. Sed rutrum risus neque, vitae condimentum odio ultricies.'],
            ['name' => 'site_title', 'value' => 'Troopers, la Légion Fédérale'],
            ['name' => 'site_title_abbr', 'value' => 'TLF'],
            ['name' => 'site_statut', 'value' => 'true'],
            ['name' => 'site_version', 'value' => '5.0'],
            ['name' => 'site_release', 'value' => 'Alpha 1.0.8'],
            ['name' => 'webmaster_nom', 'value' => 'Sylvain FLORIDE'],
            ['name' => 'webmaster_email', 'value' => 'sfloride@gmail.com'],
            ['name' => 'auteur_nom', 'value' => 'Sylvain FLORIDE'],
            ['name' => 'auteur_email', 'value' => 'sfloride@gmail.com'],
            ['name' => 'meta_keywords', 'value' => 'Troopers, Légion, Fédérale, TLF, PbEM, JdR, jeu de rôle, Jeu par correspondance'],
            ['name' => 'meta_description', 'value' => 'Troopers, la Légion Fédérale est un jeu de rôle par  correspondance '
                . 'se déroulant dans un univers futuriste (anticipation), créé par Sylvain FLORIDE et Nicolas SEGUINEAU, ' 
                . 'd\'après une idée originale de Sylvain FLORIDE, développé et maintenu par des bénévoles.' . PHP_EOL
                . 'Pas complètement situé dans un univers dystopique, il de dépeint pas un monde qui est dirigé par une Fédération '
                . 'très autoritaire et ou l\'individu n\'est mis en avant qu\'en tant que citoyen. ' . PHP_EOL
                . 'Il s\'inspire librement d\'univers de livres, films, série TV, jeux de rôle ou vidéo '
                . '(Troopers, Alien, Judge Dredd, COSMO 1999, Star Trek, X-COM, Shadowrun, etc...).'],
            ['name' => 'remerciements', 'value' => 'Chargé(s) de projet : Sylvain FLORIDE, Nicolas SEGUINEAU
Developeur(s) Web (PHP) : Sylvain FLORIDE
Developeur(s) Web (Symfony 5) : Sylvain FLORIDE
Interface Graphique (CSS) : Sylvain FLORIDE
Interface Graphique (JQuery) : Sylvain FLORIDE
Interface Graphique (Image) : Sylvain FLORIDE
Interface Graphique (Design) : Sylvain FLORIDE
Testeur(s) : Sylvain FLORIDE, Nicolas SEGUINEAU, Hélène BOUTELOUP
Developpeur(s) Background : Sylvain FLORIDE, Nicolas SEGUINEAU, Hélène BOUTELOUP'
            ],
        ];
    }
}

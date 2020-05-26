<?php
// src\DataFixtures\SiteParamsFixtures.php
namespace App\DataFixtures;

use App\Entity\SiteParams;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class SiteParamsFixtures
 *
 * PHP version 7.2
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class SiteParamsFixtures extends Fixture
{
    /**
     * Load
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $params = [
            ['nom' => 'annee_debut', 'valeur' => '2441'],
            ['nom' => 'regiment_nom', 'valeur' => '228ème Régiment de la Légion Fédérale'],
            ['nom' => 'regiment_abbr', 'valeur' => '228e R.L.F.'],
            ['nom' => 'presentation', 'valeur' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Pellentesque convallis lacinia pellentesque. Cras gravida, neque sed lacinia malesuada, arcu 
                tellus commodo magna, sed tempor nisl tellus eget mi. Suspendisse at pulvinar nulla. In 
                condimentum imperdiet velit a pellentesque. Proin enim ligula, eleifend eu ligula volutpat, 
                posuere scelerisque orci. Proin congue id tortor nec gravida. Fusce rhoncus interdum sapien 
                id auctor. Aliquam diam arcu, sagittis non ipsum eu, convallis volutpat risus. Nam auctor, 
                risus a suscipit imperdiet, nibh urna sollicitudin justo, sit amet aliquet ipsum enim sit 
                amet sem. Proin mi arcu, cursus vitae purus sed, malesuada luctus nulla. Etiam at justo at 
                neque efficitur rutrum. Vestibulum a augue purus.
                Donec gravida nunc dui, non accumsan leo rhoncus et. Suspendisse pellentesque feugiat magna,
                ut mollis justo dignissim at. Ut sit amet tempus arcu, at volutpat libero. Etiam libero dui, 
                eleifend ut ligula sit amet, elementum interdum mauris. Nulla viverra ante eget maximus maximus. 
                Etiam ex metus, fringilla ac pharetra et, dignissim eget urna. Etiam maximus ornare ex eget 
                lacinia. Aliquam vel mauris eget mi semper pellentesque sit amet a augue. Proin auctor mollis 
                dolor nec auctor. Curabitur eget diam ut felis mattis sollicitudin. Sed rutrum risus neque, 
                vitae condimentum odio ultricies.'],
            ['nom' => 'statut', 'valeur' => 'true'],
            ['nom' => 'version', 'valeur' => '5.0'],
            ['nom' => 'release', 'valeur' => 'Alpha 1.0.0'],
            ['nom' => 'webmaster_nom', 'valeur' => 'Sylvain FLORIDE'],
            ['nom' => 'webmaster_email', 'valeur' => 'sfloride@gmail.com'],
            ['nom' => 'auteur_nom', 'valeur' => 'Sylvain FLORIDE'],
            ['nom' => 'auteur_email', 'valeur' => 'sfloride@gmail.com'],
            ['nom' => 'meta_keywords', 'valeur' => 'Troopers, Légion, Fédérale, TLF, PbEM, JdR, Jeu par correspondance'],
            ['nom' => 'meta_description', 'valeur' => 'Troopers, la Légion Fédérale est un jeu de rôle par 
                correspondance se déroulant dans un univers futuriste (anticipation), créé par Sylvain FLORIDE et Nicolas SEGUINEAU, 
                d\'après une idée originale de Sylvain FLORIDE, développé et maintenu par des bénévoles.
                Il s\'inspire librement d\'univers de films ou de jeu vidéo (Troopers, Alien, Judge Dredd, etc...).'],
            ['nom' => 'remerciements', 'valeur' => 'Chargé(s) de projet : Sylvain FLORIDE, Nicolas SEGUINEAU
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

        foreach ($params as $param) {
            $siteParams = (new SiteParams())    // On crée un paramètre
                ->setNom($param['nom'])         // On la clé
                ->setValeur($param['valeur'])   // On la valeur
            ;

            $manager->persist($siteParams);
        }

        $manager->flush();

        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder():int {
        return 1000;
    }
}

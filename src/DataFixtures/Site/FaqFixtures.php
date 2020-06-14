<?php
// src\DataFixtures\Site\FaqFixtures.php
namespace App\DataFixtures\Site;

use App\Entity\Site\Faq;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class FaqFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 */
class FaqFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $faq = (new Faq())
                ->setQuestion(substr($faker->sentence(15, true), 0, -1))
                ->setReponse($faker->paragraph(4, true))
            ;

            $manager->persist($faq);
        }
        
        $manager->flush();
    }
}

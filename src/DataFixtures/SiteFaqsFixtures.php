<?php

namespace App\DataFixtures;

use App\Entity\SiteFaqs;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SiteFaqsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $faq = (new Sitefaqs())
                ->setQuestion(substr($faker->sentence(15, true), 0, -1))
                ->setReponse($faker->paragraph(4, true))
            ;

            $manager->persist($faq);
        }
        
        $manager->flush();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getOrder():int
    {
        return 1000;
    }
}

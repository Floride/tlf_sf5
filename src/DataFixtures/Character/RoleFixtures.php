<?php
// src\DataFixtures\Character\RoleFixtures.php
namespace App\DataFixtures\Character;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * Class RoleFixtures
 *
 * PHP version 7.2.5
 *
 * @package    App\DataFixtures
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 */
class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder():int
    {
        return 1200;
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
                'name' => 'Accès Libre',
                'abbreviation' => 'AL',
                'type' => 1,
                'category' => 0,
                'playable' => true
            ],
        ];
    }
}

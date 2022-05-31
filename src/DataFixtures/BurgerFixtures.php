<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BurgerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=0;$i<=5;$i++){
        $burger = new Burger();
        $burger->setNom('double burger');
        $burger->setPrix(3000);
        $manager->persist($burger);
    }
        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImageFixtures extends Fixture implements DependentFixtureInterface 
{
    public function load(ObjectManager $manager): void
    {
        for($i=0;$i<=5;$i++){
        $image = new Image();
        $image->setNom('images/burger.png');
        
         $manager->persist($image);
        }
         


         $manager->flush();

    }
    public function getDependencies()
    {
        return[BurgerFixtures::class];
        
    }
}

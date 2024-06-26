<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Factory\DataFactory;
use App\Factory\ModuleFactory;
use App\Factory\UserFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        // going to excecute the DataFactory, Module Factory,UserFactory and add it to the database 
        DataFactory::createMany(10);
        ModuleFactory::createMany(10);
        //UserFactory::createOne();
        UserFactory::createMany(10); //you can create 1 user factory  you have just to uncomment
        // In the userFactory class you are going to use this :
        /**/ 

        // so we use the Fixtures to automaticaly add object in the data base 
        // up i have just added 10 data & module object with on user i my database 

        $manager->flush();
    }// To run fixture use this:  symfony console doctrine:fixtures:load
    
}

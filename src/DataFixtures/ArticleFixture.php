<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 100 ; $i++){
            $article = new Article();
            $article->setTitle($faker->words(5,true))
                ->setContent($faker->sentences(10,true));
               // ->setSlug();
            $manager->persist($article);
        }
        $manager->flush();
    }
}

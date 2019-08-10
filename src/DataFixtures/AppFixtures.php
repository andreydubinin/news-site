<?php

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('ru_RU');
    }

    public function load(ObjectManager $manager)
    {

        for($i = 0; $i < 20; $i++){
            $news = new News();
            $news->setName($this->faker->words(3, true));
            $news->setDescription($this->faker->words(8, true));
            $news->setText($this->faker->text);

            $manager->persist($news);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
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

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $categories = [];
        for ($i = 0; $i < 5; $i++) {
            $category = $this->makeCategory();
            $categories[] = $category;
            $manager->persist($category);
        }
        $this->makeTreeCategories($categories);


        for ($i = 0; $i < 20; $i++) {
            $news = $this->makeNews();

            $comment = $this->makeComment();
            $comment->setNews($news);

            $category = $this->getRandomCategory($categories);
            $news->setCategory($category);

            $manager->persist($news);
            $manager->persist($comment);
        }
        $manager->flush();
    }

    /**
     * @return News
     */
    private function makeNews(): News
    {
        $news = new News();
        $news->setName($this->faker->words(3, true));
        $news->setDescription($this->faker->words(8, true));
        $news->setText($this->faker->text);
        $news->setIsActive(true);

        return $news;
    }

    /**
     * @return Comment
     */
    private function makeComment(): Comment
    {
        $comment = new Comment();
        $comment->setText($this->faker->words(8, true));
        $comment->setName($this->faker->name);

        return $comment;
    }

    /**
     * @return Category
     */
    private function makeCategory(): Category
    {
        $category = new Category();
        $category->setName($this->faker->word);

        return $category;
    }

    /**
     * Создаем рандомную древовидную структуру
     * @param array $categories
     */
    private function makeTreeCategories(array $categories): void
    {
        $curDepthLevel = 1;
        /**
         * @var int $key
         * @var Category $category
         */
        foreach ($categories as $key => $category) {
            if ($curDepthLevel > 1 && isset($categories[$key - 1])) {
                $category->setParent($categories[$key - 1]);
            }
            $curDepthLevel++;
            if ($curDepthLevel > 3) {
                $curDepthLevel = 1;
            }

        }
    }

    /**
     * @param array $categories
     * @return Category
     */
    private function getRandomCategory(array $categories): Category {
        $count = count($categories);

        return $categories[rand(0, $count - 1)];
    }
}

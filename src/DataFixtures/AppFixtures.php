<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Post;
use App\Entity\Category;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(); // Create a Faker Generator

        // Create a few test categories
        $categories = [];
        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);
            $categories[] = $category; // Save for later use
        }

        // Create a few test articles
        for ($i = 1; $i <= 20; $i++) {
            $post = new Post();
            $post->setTitle($faker->sentence);
            $post->setContent($faker->paragraph(5, true));
            $post->setCategory($categories[rand(0, 4)]); // Associate with a random category
            $post->setPublishedDate($faker->dateTimeThisYear);
            $manager->persist($post);
        }

        $manager->flush();
    }
}
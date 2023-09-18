<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create(); 

        // Create categories
        $categories = ['Technologie', 'Santé', 'Voyage', 'Education', 'Sports'];

        // Predefined list of realistic titles
        $titles = [
            "Les dernières avancées en matière de technologie d'intelligence artificielle",
            "10 astuces pour maintenir une bonne santé mentale",
            "Destinations incontournables pour 2023",
            "Les impacts de l'éducation en ligne sur les méthodes d'apprentissage traditionnelles",
            "Les bienfaits du sport sur le bien-être mental",
            "Comment la 5G va transformer notre quotidien?",
            "Découverte : nouveaux traitements potentiels pour la maladie d'Alzheimer",
            "Explorer le monde: Les meilleures applications de voyage",
            "L'importance de la formation continue dans un monde en évolution rapide",
            "Sports d'équipe versus sports individuels : Quel est le meilleur pour vous?",
            "Les innovations technologiques qui façonnent 2023.",
            "L'impact du yoga sur la réduction du stress quotidien.",
            "Les plus grandes réalisations spatiales de la dernière décennie.",
            "L'importance de la biodiversité pour un avenir durable.",
            "La cuisine fusion : quand l'Est rencontre l'Ouest dans votre assiette.",
            "Comment les énergies renouvelables transforment le paysage énergétique mondial.",
            "Les villes les plus vertes du monde en 2023.",
            "Les dangers cachés des réseaux sociaux pour la santé mentale.",
            "L'essor de l'agriculture urbaine : nourrir les villes du futur.",
            "La renaissance de l'art analogique à l'ère numérique.",
            "Les mystères non résolus de l'océan profond.",
            "L'influence de la musique sur la productivité au travail.",
            "Les bienfaits méconnus de la méditation quotidienne.",
            "La réalité virtuelle : le futur de l'éducation?",
            "Les super-aliments que tout le monde devrait inclure dans son régime alimentaire.",
            "Décryptage : comment le machine learning affecte-t-il notre quotidien?",
            "Les parcs nationaux les plus impressionnants du monde.",
            "Les défis et triomphes des athlètes paralympiques.",
            "La montée des économies émergentes : focus sur le Brésil, l'Inde et la Chine.",
            "Comment les podcasts ont révolutionné le monde de la narration.",
        ];
        
        shuffle($titles); // Mix the titles

        // Encoded password string
        $encodedPassword = '$2y$10$1BbZWvD5Dw1AvJn4vllkb.tbmC9qg7.oFUOR/0coQOXmwBOnMRIKa';

        // Create Users
        $usersData = [
            ['john.doe@example.com', 'JohnDoe', $encodedPassword, []],
            ['jane.doe@example.com', 'JaneDoe', $encodedPassword, []],
            ['alice.smith@example.com', 'AliceSmith', $encodedPassword, []],
            ['bob.jones@example.com', 'BobJones', $encodedPassword, []],
            ['carol.wilson@example.com', 'CarolWilson', $encodedPassword, []],
            ['admin@example.com', 'Admin', $encodedPassword, ['ROLE_ADMIN']],
        ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $categoriesEntities[] = $category;
        }

        $posts = [];  // To store Post objects for commenting later
        // Create posts
        for ($i = 1; $i <= 20 && $i <= count($titles); $i++) {
            $post = new Post();
            $post->setTitle($titles[$i-1]);
            $post->setContent($faker->paragraphs($faker->numberBetween(3, 7), true));
            $post->setCategory($faker->randomElement($categoriesEntities));
            $post->setPublishedDate($faker->dateTimeBetween('-1 years', 'now'));
            $post->setImage("https://picsum.photos/800/400?random={$i}");  

            $manager->persist($post);
            $posts[] = $post;  // Store the post
        }

        $users = [];  // To store User objects for commenting later
        // Create users
        foreach ($usersData as $data) {
            $user = new User();
            $user->setEmail($data[0]);
            $user->setUsername($data[1]);
            $user->setPassword($data[2]);
            $user->setRoles($data[3]);

            $manager->persist($user);
            $users[] = $user;  // Store the user
        }

        // Add comments to posts
        foreach ($posts as $post) {
            for ($j = 0; $j < rand(1, 5); $j++) {
                $comment = new Comment();
                $comment->setContent($faker->sentence());
                $comment->setCreatedAt($faker->dateTimeBetween('-1 years', 'now'));
                $comment->setPost($post);
                $comment->setUser($faker->randomElement($users));
                
                $manager->persist($comment);
            }
        }

        $manager->flush();
    }
}
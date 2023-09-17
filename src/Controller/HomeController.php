<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        // Fetch all posts in descending order
        $posts = $postRepository->findAllOrderedByDate();

        // Fetch all categories
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }
}
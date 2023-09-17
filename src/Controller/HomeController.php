<?php

namespace App\Controller;

use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request,PostRepository $postRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator): Response
    {
        $query = $postRepository->createQueryBuilder('a')
            ->orderBy('a.published_date', 'DESC')  // Sort articles by publication date
            ->getQuery();

        $posts = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Gets the page number from the query, default 1
            4 // Number of articles per page
        );

        // Fetch all categories
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'categories' => $categories
        ]);
    }
}
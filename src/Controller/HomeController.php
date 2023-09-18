<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, PostRepository $postRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator): Response
    {
        // Retrieve the category ID if provided
        $categoryId = $request->query->get('category'); 
    
        // Create a query to fetch posts, sorted by published date in descending order
        $queryBuilder = $postRepository->createQueryBuilder('a')->orderBy('a.published_date', 'DESC');
    
        // If a category ID is provided, add a condition to the query
        if ($categoryId) {
            $queryBuilder->andWhere('a.category = :categoryId')
                         ->setParameter('categoryId', $categoryId);
        }
    
        // Finalize the query
        $query = $queryBuilder->getQuery();
    
        // Use paginator to paginate the results
        $posts = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Retrieve the page number from the query, defaulting to 1 if not provided
            3 // Number of posts per page
        );
    
        // Retrieve all available categories
        $categories = $categoryRepository->findAll();
    
        // Render the view with the paginated posts and available categories
        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'categories' => $categories,
            'selectedCategory' => $categoryId
        ]);
    }    

    #[Route('/post/{id}', name: 'app_show_post')]
    public function show(int $id, PostRepository $postRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Find the post by its ID
        $post = $postRepository->find($id);
    
        // If the post is not found, throw a not found exception
        if (!$post) {
            throw $this->createNotFoundException('The requested post does not exist.');
        }
    
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
                return $this->redirectToRoute('app_login');
            }
            
            if ($form->isValid()) {
                $comment->setPost($post);
                $comment->setUser($this->getUser()); 
                $comment->setCreatedAt(new \DateTime());
    
                $entityManager->persist($comment);
                $entityManager->flush();
    
                return $this->redirectToRoute('app_show_post', ['id' => $post->getId()]);
            }
        }
    
        // Render the post details view
        return $this->render('home/show.html.twig', [
            'post' => $post,
            'commentForm' => $form->createView()
        ]);
    }    
}
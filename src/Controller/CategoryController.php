<?php

namespace App\Controller;

use App\Entity\Category;
use App\Services\Contracts\NewsServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $newsService;

    public function __construct(NewsServiceInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @Route("/category", name="category", methods={"GET"})
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/category/{slug}", name="category.show", methods={"GET"})
     */
    public function show(Request $request, Category $category)
    {
        list($news, $lastPage) = $this->newsService->getNewsPagination($request, [
            'is_active' => true,
            'category' => $category->getId()
        ]);
        return $this->render('category/show.html.twig', [
            'category' => $category,
            'news' => $news,
            'last_page' => $lastPage
        ]);
    }
}

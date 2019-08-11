<?php

namespace App\Controller;

use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\NewsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    /** @var NewsServiceInterface $newsService */
    private $newsService;

    /** @var CategoryServiceInterface $categoryService */
    private $categoryService;

    public function __construct(NewsServiceInterface $newsService, CategoryServiceInterface $categoryService)
    {
        $this->newsService = $newsService;
        $this->categoryService = $categoryService;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function index(Request $request)
    {
        list($news, $lastPage) = $this->newsService->getNewsPagination($request, [
            'is_active' => true
        ]);
        $categories = $this->categoryService->getTree();
        return $this->render('default/index.html.twig', [
            'news' => $news,
            'categories' => $categories,
            'last_page' => $lastPage
        ]);
    }
}

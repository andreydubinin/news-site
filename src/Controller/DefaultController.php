<?php

namespace App\Controller;

use App\Services\Contracts\NewsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    private $newsService;

    public function __construct(NewsServiceInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(Request $request)
    {
        list($news, $lastPage) = $this->newsService->getNewsPagination($request);
        return $this->render('default/index.html.twig', [
            'news' => $news,
            'last_page' => $lastPage
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\News;
use App\Form\CommentType;
use App\Services\Contracts\NewsServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class NewsController extends AbstractController
{
    /** @var NewsServiceInterface $newsService */
    private $newsService;

    public function __construct(NewsServiceInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @return Response
     * @Route("/news", name="news", methods={"GET"})
     */
    public function index(Request $request)
    {
        list($news, $lastPage) = $this->newsService->getNewsPagination($request, [
            'is_active' => true
        ], 10);
        return $this->render('news/index.html.twig', [
            'news' => $news,
            'last_page' => $lastPage
        ]);
    }

    /**
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/news/{slug}", name="news.show", methods={"GET"})
     */
    public function show(News $news): Response
    {
        $formComment = $this->createForm(CommentType::class, (new Comment()), [
            'action' => '/comment',
            'method' => 'POST'
        ]);
        $formComment->add('news', HiddenType::class, [
            'data' => $news->getId()
        ]);
        return $this->render('news/show.html.twig', [
            'news' => $news,
            'formComment' => $formComment->createView()
        ]);
    }
}

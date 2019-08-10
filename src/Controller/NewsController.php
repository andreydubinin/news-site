<?php

namespace App\Controller;

use App\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    /**
     * @Route("/news", name="news")
     */
    public function index()
    {
        return $this->render('news/index.html.twig', [
            'controller_name' => 'NewsController',
        ]);
    }

    /**
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/news/{slug}", name="news.detail")
     */
    public function detail(News $news)
    {
        return $this->render('news/detail.html.twig', [
            'news' => $news
        ]);
    }
}

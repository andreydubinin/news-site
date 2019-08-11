<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Form\NewsType;
use App\Services\Contracts\NewsServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class NewsController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class NewsController extends AbstractController
{
    private $newsService;

    public function __construct(NewsServiceInterface $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * @Route("/admin/news", name="admin.news", methods={"GET"})
     */
    public function index(Request $request)
    {
        list($news, $lastPage) = $this->newsService->getNewsPagination($request, [], 10);
        return $this->render('admin/news/index.html.twig', [
            'news' => $news,
            'last_page' => $lastPage
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/news/create", name="admin.news.create", methods={"GET"})
     */
    public function create(Request $request)
    {
        $news = new News();
        $formNews = $this->createForm(NewsType::class, $news, [
            'action' => $this->generateUrl('admin.news.store'),
            'method' => 'POST'
        ]);
        return $this->render('admin/news/create.html.twig', [
            'form' => $formNews->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param News $news
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/news/{id}", name="admin.news.edit", methods={"GET"})
     */
    public function edit(Request $request, News $news)
    {
        $formNews = $this->createForm(NewsType::class, $news, [
            'action' => $this->generateUrl('admin.news.update', ['id' => $news->getId()]),
            'method' => 'PUT'
        ]);
        return $this->render('admin/news/edit.html.twig', [
            'news' => $news,
            'form' => $formNews->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route("/admin/news", name="admin.news.store", methods={"POST"})
     */
    public function store(Request $request)
    {
        $news = new News();
        $this->newsService->saveForm($request, $news);

        if ($request->request->has('referer')) {
            return $this->redirect($request->request->get('referer'));
        }
        return $this->redirectToRoute('admin');
    }

    /**
     * @param Request $request
     * @param News $news
     * @return RedirectResponse
     * @Route("/admin/news/{id}", name="admin.news.update", methods={"PUT"})
     */
    public function update(Request $request, News $news)
    {
        $this->newsService->saveForm($request, $news);

        if ($request->request->has('referer')) {
            return $this->redirect($request->request->get('referer'));
        }
        return $this->redirectToRoute('admin');
    }

    /**
     * @param News $news
     * @return RedirectResponse
     * @Route("/news/{id}", name="admin.news.destroy", methods={"DELETE"})
     */
    public function destroy(Request $request, News $news): RedirectResponse
    {
        $this->newsService->removeNews($news);

        if ($request->request->has('referer')) {
            return $this->redirect($request->request->get('referer'));
        }
        return $this->redirectToRoute('admin');
    }
}

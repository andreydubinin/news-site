<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\NewsServiceInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Class CategoryController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class CategoryController extends AbstractController
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
     * @Route("/admin/categories", name="admin.categories", methods={"GET"})
     */
    public function index(Request $request)
    {
        list($categories, $lastPage) = $this->categoryService->getCategoryPagination($request, [], 10);
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
            'last_page' => $lastPage
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/categories/create", name="admin.category.create", methods={"GET"})
     */
    public function create(Request $request)
    {
        $category = new Category();
        $formNews = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('admin.categories.store'),
            'method' => 'POST'
        ]);
        return $this->render('admin/category/create.html.twig', [
            'form' => $formNews->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/categories/{id}", name="admin.category.edit", methods={"GET"})
     */
    public function edit(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category, [
            'action' => $this->generateUrl('admin.category.update', ['id' => $category->getId()]),
            'method' => 'PUT'
        ]);
        return $this->render('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @Route("/admin/categories", name="admin.categories.store", methods={"POST"})
     */
    public function store(Request $request)
    {
        $category = new Category();
        $this->categoryService->saveForm($request, $category);

        if ($request->request->has('referer')) {
            return $this->redirect($request->request->get('referer'));
        }
        return $this->redirectToRoute('admin');
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return RedirectResponse
     * @Route("/admin/categories/{id}", name="admin.category.update", methods={"PUT"})
     */
    public function update(Request $request, Category $category)
    {
        $this->categoryService->saveForm($request, $category);

        if ($request->request->has('referer')) {
            return $this->redirect($request->request->get('referer'));
        }
        return $this->redirectToRoute('admin');
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @Route("/admin/categories/{id}", name="admin.category.destroy", methods={"DELETE"})
     */
    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->categoryService->removeCategory($category);

        if ($request->request->has('referer')) {
            return $this->redirect($request->request->get('referer'));
        }
        return $this->redirectToRoute('admin');
    }
}

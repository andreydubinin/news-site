<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 1:37
 */

namespace App\Services;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\Contracts\CategoryRepositoryInterface;
use App\Services\Contracts\CategoryServiceInterface;
use App\Services\Contracts\PaginationServiceInterface;
use App\Services\Traits\PaginationTrait;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryService implements CategoryServiceInterface
{
    use PaginationTrait;

    const ITEMS_PER_PAGE = 10;

    /** @var CategoryRepositoryInterface $categoryRepository */
    private $categoryRepository;

    /** @var PaginationServiceInterface $paginationService */
    private $paginationService;

    /** @var ContainerInterface */
    private $container;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        PaginationServiceInterface $paginationService,
        ContainerInterface $container
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->paginationService = $paginationService;
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param array $filters
     * @param int $countPerPage
     * @return array
     */
    public function getCategoryPagination(Request $request, array $filters = [], int $countPerPage = self::ITEMS_PER_PAGE): array
    {
        $query = $this->categoryRepository->createCategoryQueryBuilder($filters);

        return $this->getPagination($this->paginationService, $request, $query, $countPerPage, 'categories');
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        return $this->categoryRepository
            ->createCategoryQueryBuilder([
                'parent' => ['operand' => 'IS', 'value' => 'NULL']
            ])
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return Category
     */
    public function saveForm(Request $request, Category $category): Category
    {
        $form = $this->container->get('form.factory')->create(CategoryType::class, $category, [
            'method' => $request->getMethod()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->save($category);
        }

        return $category;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category): void
    {
        $this->categoryRepository->remove($category);
    }
}
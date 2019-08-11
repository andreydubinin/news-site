<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 18:40
 */

namespace App\Services;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\Contracts\NewsRepositoryInterface;
use App\Services\Contracts\NewsServiceInterface;
use App\Services\Contracts\PaginationServiceInterface;
use App\Services\Traits\PaginationTrait;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class NewsService implements NewsServiceInterface
{
    use PaginationTrait;

    const ITEMS_PER_PAGE = 3;

    /** @var NewsRepositoryInterface $newsRepository */
    private $newsRepository;

    /** @var PaginationServiceInterface $paginationService */
    private $paginationService;

    /** @var ContainerInterface */
    private $container;

    public function __construct(
        NewsRepositoryInterface $newsRepository,
        PaginationServiceInterface $paginationService,
        ContainerInterface $container
    )
    {
        $this->newsRepository = $newsRepository;
        $this->paginationService = $paginationService;
        $this->container = $container;
    }

    /**
     * @param Request $request
     * @param array $filters
     * @param int $countPerPage
     * @return array
     */
    public function getNewsPagination(Request $request, array $filters = [], int $countPerPage = self::ITEMS_PER_PAGE): array
    {
        $this->paginationService->setDefaultSortField('created_at');
        $this->paginationService->setDefaultOrder('desc');
        $query = $this->newsRepository->createNewsQueryBuilder($filters);

        return $this->getPagination($this->paginationService, $request, $query, $countPerPage, 'news');
    }

    /**
     * @param Request $request
     * @param News $news
     * @return News
     */
    public function saveForm(Request $request, News $news): News
    {
        $form = $this->container->get('form.factory')->create(NewsType::class, $news, [
            'method' => $request->getMethod()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('news');
            if (!isset($data['isActive'])) {
                $news->setIsActive(false);
            }
            $this->newsRepository->save($news);
        }

        return $news;
    }

    /**
     * @param News $news
     */
    public function removeNews(News $news): void
    {
        $this->newsRepository->remove($news);
    }
}
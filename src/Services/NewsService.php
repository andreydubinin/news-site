<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 18:40
 */

namespace App\Services;

use App\Repository\Contracts\NewsRepositoryInterface;
use App\Services\Contracts\NewsServiceInterface;
use App\Services\Contracts\PaginationServiceInterface;
use Symfony\Component\HttpFoundation\Request;

class NewsService implements NewsServiceInterface
{
    const ITEMS_PER_PAGE = 3;

    private $newsRepository;

    private $paginationService;

    public function __construct(NewsRepositoryInterface $newsRepository, PaginationServiceInterface $paginationService)
    {
        $this->newsRepository = $newsRepository;
        $this->paginationService = $paginationService;
    }

    public function getNewsPagination(Request $request)
    {
        $query = $this->newsRepository->createQuery('news');
        $results = $this->paginationService->paginate($query, $request, self::ITEMS_PER_PAGE, 'news');
        $lastPage = $this->paginationService->lastPage($results);

        return [
            $results,
            $lastPage
        ];
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 18:04
 */

namespace App\Services\Traits;


use App\Services\Contracts\PaginationServiceInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

trait PaginationTrait
{
    /**
     * @param PaginationServiceInterface $paginationService
     * @param Request $request
     * @param QueryBuilder $query
     * @param int $countPerPage
     * @param string $name Pagination name
     * @return array
     */
    protected function getPagination(
        PaginationServiceInterface $paginationService,
        Request $request,
        QueryBuilder $query,
        int $countPerPage,
        string $name
    ): array
    {
        $results = $paginationService->paginate($query, $request, $countPerPage, $name);
        $lastPage = $paginationService->lastPage($results);

        return [
            $results,
            $lastPage
        ];
    }
}
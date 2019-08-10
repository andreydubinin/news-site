<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 18:45
 */

namespace App\Services;

use App\Services\Contracts\PaginationServiceInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

class PaginationService implements PaginationServiceInterface
{
    const DEFAULT_SORT_FIELD = 'created_at';
    const DEFAULT_ORDER = 'desc';
    /**
     * @param QueryBuilder|Query $query
     * @param Request $request
     * @param int $limit
     * @param string $name
     * @return Paginator
     */
    public function paginate($query, Request $request, int $limit, string $name = 'p'): Paginator
    {
        $query->addOrderBy($name.'.'.$this->getSort($request), $this->getOrder($request));
        $currentPage = $this->getCurrentPage($request, $name);
        $paginator = new Paginator($query);
        $paginator
            ->getQuery()
            ->setFirstResult($limit * ($currentPage - 1))
            ->setMaxResults($limit);
        return $paginator;
    }
    /**
     * @param Paginator $paginator
     * @return int
     */
    public function lastPage(Paginator $paginator): int
    {
        return ceil($paginator->count() / $paginator->getQuery()->getMaxResults());
    }
    /**
     * @param Paginator $paginator
     * @return int
     */
    public function total(Paginator $paginator): int
    {
        return $paginator->count();
    }
    /**
     * @param Paginator $paginator
     * @return bool
     */
    public function currentPageHasNoResult(Paginator $paginator): bool
    {
        return !$paginator->getIterator()->count();
    }

    private function getSort(Request $request): string
    {
        if ($request->query->has('sort')) {
            return $request->query->get('sort');
        }
        return self::DEFAULT_SORT_FIELD;
    }

    private function getOrder(Request $request): string
    {
        if ($request->query->has('order')) {
            return $request->query->get('order');
        }
        return self::DEFAULT_ORDER;
    }

    private function getCurrentPage(Request $request, string $name): string
    {
        return $request->query->getInt($name) ?: 1;
    }
}
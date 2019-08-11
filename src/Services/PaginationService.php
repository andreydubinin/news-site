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
    /** @var string $defaultSortField */
    private $defaultSortField = 'id';

    /** @var string $defaultOrder */
    private $defaultOrder = 'desc';

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
     * @param string $field
     */
    public function setDefaultSortField(string $field): void
    {
        $this->defaultSortField = $field;
    }

    /**
     * @param string $order
     */
    public function setDefaultOrder(string $order): void
    {
        $this->defaultOrder = $order;
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

    /**
     * @param Request $request
     * @return string
     */
    private function getSort(Request $request): string
    {
        if ($request->query->has('sort')) {
            return $request->query->get('sort');
        }
        return $this->defaultSortField;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function getOrder(Request $request): string
    {
        if ($request->query->has('order')) {
            return $request->query->get('order');
        }
        return $this->defaultOrder;
    }

    /**
     * @param Request $request
     * @param string $name
     * @return string
     */
    private function getCurrentPage(Request $request, string $name): string
    {
        return $request->query->getInt($name) ?: 1;
    }
}
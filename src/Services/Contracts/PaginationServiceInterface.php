<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 18:46
 */

namespace App\Services\Contracts;


use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;

interface PaginationServiceInterface
{
    public function paginate($query, Request $request, int $limit, string $name = 'p'): Paginator;
    public function lastPage(Paginator $paginator): int;
    public function total(Paginator $paginator): int;
    public function currentPageHasNoResult(Paginator $paginator): bool;
}
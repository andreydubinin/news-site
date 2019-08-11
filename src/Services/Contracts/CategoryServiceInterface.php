<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 1:37
 */

namespace App\Services\Contracts;


use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

interface CategoryServiceInterface
{
    public function getCategoryPagination(Request $request, array $filters = [], int $countPerPage = 10): array;
    public function saveForm(Request $request, Category $category): Category;
    public function removeCategory(Category $category): void;
    public function getTree(): array;
}
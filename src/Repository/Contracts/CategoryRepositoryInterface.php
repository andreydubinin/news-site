<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 11.08.2019
 * Time: 17:57
 */

namespace App\Repository\Contracts;


use App\Entity\Category;
use Doctrine\ORM\QueryBuilder;

interface CategoryRepositoryInterface
{
    public function createCategoryQueryBuilder(array $filters = []): QueryBuilder;
    public function remove(Category $category): void;
    public function save(Category $category): void;
}
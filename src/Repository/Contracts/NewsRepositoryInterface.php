<?php
/**
 * Created by PhpStorm.
 * User: Andrey Dubinin
 * Date: 10.08.2019
 * Time: 17:31
 */

namespace App\Repository\Contracts;


use App\Entity\Category;
use App\Entity\News;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface NewsRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);
    public function findOneBy(array $criteria, array $orderBy = null);
    public function findAll();
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null);
    public function remove(News $news): void;
    public function save(News $news): void;
    public function createNewsQueryBuilder(array $filters = []): QueryBuilder;
}
<?php

namespace App\Repository;

use App\Entity\Category;
use App\Repository\Contracts\CategoryRepositoryInterface;
use App\Repository\Traits\SetFilterTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository implements CategoryRepositoryInterface
{
    use SetFilterTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param array $filters
     * @return QueryBuilder
     */
    public function createCategoryQueryBuilder(array $filters = []): QueryBuilder
    {
        $queryBuilder = parent::createQueryBuilder('categories');
        if (!empty($filters)) {
            $this->setFilter($queryBuilder, $filters, 'categories');
        }
        return $queryBuilder;
    }

    /**
     * @param Category $category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(Category $category): void
    {
        $this->getEntityManager()->remove($category);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Category $category
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Category $category): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($category);
        $entityManager->flush();
    }
}

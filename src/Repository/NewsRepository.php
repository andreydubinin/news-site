<?php

namespace App\Repository;

use App\Entity\News;
use App\Repository\Contracts\NewsRepositoryInterface;
use App\Repository\Traits\SetFilterTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository implements NewsRepositoryInterface
{
    use SetFilterTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    /**
     * @param array $filters
     * @return QueryBuilder
     */
    public function createNewsQueryBuilder(array $filters = []): QueryBuilder
    {
        $queryBuilder = parent::createQueryBuilder('news');
        if (!empty($filters)) {
            $this->setFilter($queryBuilder, $filters, 'news');
        }
        return $queryBuilder;
    }

    /**
     * @param News $news
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(News $news): void
    {
        $this->getEntityManager()->remove($news);
        $this->getEntityManager()->flush();
    }

    /**
     * @param News $news
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(News $news): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($news);
        $entityManager->flush();
    }
}

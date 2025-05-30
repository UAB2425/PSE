<?php

namespace App\Repository;

use App\Entity\HighlanderBlogArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HighlanderBlogArticle>
 */
class HighlanderBlogArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HighlanderBlogArticle::class);
    }

    public function getAllArticles(): array{
        return $this->createQueryBuilder('a')
        ->orderBy('a.article_date', 'DESC')
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return HighlanderBlogArticle[] Returns an array of HighlanderBlogArticle objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?HighlanderBlogArticle
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

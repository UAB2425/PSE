<?php

namespace App\Repository;

use App\Entity\BzoviiElenadynamic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BzoviiElenadynamic>
 */
class BzoviiElenadynamicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BzoviiElenadynamic::class);
    }


}

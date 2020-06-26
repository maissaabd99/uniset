<?php

namespace App\Repository;

use App\Entity\Iset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Iset|null find($id, $lockMode = null, $lockVersion = null)
 * @method Iset|null findOneBy(array $criteria, array $orderBy = null)
 * @method Iset[]    findAll()
 * @method Iset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Iset::class);
    }

    // /**
    //  * @return Iset[] Returns an array of Iset objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Iset
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

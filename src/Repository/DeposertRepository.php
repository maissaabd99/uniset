<?php

namespace App\Repository;

use App\Entity\Deposert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Deposert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deposert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deposert[]    findAll()
 * @method Deposert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeposertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deposert::class);
    }

    // /**
    //  * @return Deposert[] Returns an array of Deposert objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deposert
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

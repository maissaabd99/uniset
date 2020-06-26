<?php

namespace App\Repository;

use App\Entity\EnsMatiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnsMatiere|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnsMatiere|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnsMatiere[]    findAll()
 * @method EnsMatiere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnsMatiereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnsMatiere::class);
    }

    // /**
    //  * @return EnsMatiere[] Returns an array of EnsMatiere objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EnsMatiere
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

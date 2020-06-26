<?php

namespace App\Repository;

use App\Entity\EnsClasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EnsClasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnsClasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnsClasse[]    findAll()
 * @method EnsClasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnsClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnsClasse::class);
    }

    // /**
    //  * @return EnsClasse[] Returns an array of EnsClasse objects
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
    public function findOneBySomeField($value): ?EnsClasse
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

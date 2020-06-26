<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

     /**
     * @return Utilisateur[] Returns an array of Utilisateur objects
     */

    public function findByUsername($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCin($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.cin = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findOneBySomeField($value): ?Utilisateur
    {
        try {
            return $this->createQueryBuilder('u')
                ->andWhere('u.username = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }

}

<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param $value
     * @return Post[] Returns an array of Post objects
     */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :val')
            ->setParameter('val', $value)

            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField($value): ?Post
    {
        try {
            return $this->createQueryBuilder('p')
                ->andWhere('p.user = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }

}

<?php

namespace App\Repository;

use App\Entity\UserJeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserJeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserJeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserJeu[]    findAll()
 * @method UserJeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserJeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserJeu::class);
    }

    // /**
    //  * @return UserJeu[] Returns an array of UserJeu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserJeu
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

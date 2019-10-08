<?php

namespace App\Repository;

use App\Entity\UsersJeux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UsersJeux|null find($id, $lockMode = null, $lockVersion = null)
 * @method UsersJeux|null findOneBy(array $criteria, array $orderBy = null)
 * @method UsersJeux[]    findAll()
 * @method UsersJeux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersJeuxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UsersJeux::class);
    }

    // /**
    //  * @return UsersJeux[] Returns an array of UsersJeux objects
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
    public function findOneBySomeField($value): ?UsersJeux
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

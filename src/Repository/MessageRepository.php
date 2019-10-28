<?php

namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function getMessages($user_post_id, $user_get_id)
    {
        return $this->createQueryBuilder('m')
            ->select('up.id AS userPost', 'ug.id AS userGet', 'm.content', 'm.time')
            ->leftJoin('m.userPost', 'up')
            ->leftJoin('m.userGet', 'ug')
            ->andWhere('m.userPost = :post OR m.userPost = :get')
            ->andWhere('m.userGet = :get OR m.userGet = :post')
            ->orderBy('m.time', 'ASC')
            ->setParameters([
                ':post' => $user_post_id,
                ':get' => $user_get_id
            ])
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Message[] Returns an array of Message objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Message
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

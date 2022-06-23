<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }



    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function lastShippingOrder($filters): ?Order
    {
        try {
            $expr = new Expr();
            $qb = $this->createQueryBuilder('o');
            $qb->andWhere('o.id = :id')->setParameter('id', $filters['id']);
            $qb->andWhere($qb->expr()->in('o.orderStatus', ':orderStatus'))->setParameter('orderStatus', $filters['orderStatus']);
            $qb->andWhere($expr->gte('o.shippingDate', ':shippingDate'))->setParameter('shippingDate', new \DateTime('now'));

            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function getOrders()
    {
        $qb = $this->createQueryBuilder('o');
        return $qb->getQuery();
    }

}

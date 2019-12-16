<?php

namespace App\Repository;

use App\Entity\FilmShow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FilmShow|null find($id, $lockMode = null, $lockVersion = null)
 * @method FilmShow|null findOneBy(array $criteria, array $orderBy = null)
 * @method FilmShow[]    findAll()
 * @method FilmShow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmShowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilmShow::class);
    }

    public function findShowsByDate(\DateTime $date)
    {
        $qb = $this->createQueryBuilder('s')
            ->where('YEAR(s.time) = :year')
            ->andWhere('MONTH(s.time) = :month')
            ->andWhere('DAY(s.time) = :day')
            ->andWhere('HOUR(s.time) > :hour')
            ->setParameter('year', $date->format('Y'))
            ->setParameter('month', $date->format('m'))
            ->setParameter('day', $date->format('d'))
            ->setParameter('hour', $date->format('H'))
            ->orderBy('s.time')
        ;
        $query = $qb->getQuery();
        return $query->execute();
    }

    public function getShowsCount()
    {
        $qb = $this->createQueryBuilder('s')
            ->select('count(s.id)');

        $query = $qb->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Show[] Returns an array of Show objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Show
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

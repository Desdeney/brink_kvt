<?php

namespace App\Repository;

use App\Entity\Appointments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Appointments>
 */
class AppointmentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appointments::class);
    }

    public function findActiveAppointments()
    {
        return $this->createQueryBuilder('a')
            ->where('a.deactivated = false')
            ->getQuery()
            ->getResult();
    }

    public function findInactiveAppointments()
    {
        return $this->createQueryBuilder('a')
            ->where('a.deactivated = true')
            ->getQuery()
            ->getResult();
    }

    public function countUpcoming(): int
    {
        return (int)$this->createQueryBuilder('a')
            ->select('COUNT(a.id)')
            ->where('a.date >= :today')
            ->setParameter('today', new \DateTime('today'))
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return Appointments[] Returns an array of Appointments objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Appointments
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
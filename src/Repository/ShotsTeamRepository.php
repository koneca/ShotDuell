<?php

namespace App\Repository;

use App\Entity\ShotsTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShotsTeam>
 *
 * @method ShotsTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShotsTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShotsTeam[]    findAll()
 * @method ShotsTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShotsTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShotsTeam::class);
    }

    public function add(ShotsTeam $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ShotsTeam $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function update(ShotsTeam $entity, bool $flush = true): void
    {
        $this->getEntityManager()->merge($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ShotsTeam[] Returns an array of ShotsTeam objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ShotsTeam
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

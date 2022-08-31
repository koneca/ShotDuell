<?php

namespace App\Repository;

use App\Entity\ShotsStatistics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShotsStatistics>
 *
 * @method ShotsStatistics|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShotsStatistics|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShotsStatistics[]    findAll()
 * @method ShotsStatistics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShotsStatisticsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShotsStatistics::class);
    }

    public function add(ShotsStatistics $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(int $teamId, bool $flush = true): void
    {
        $this->createQueryBuilder('s')
                ->delete()
                ->where('s.teamId = :project')
                ->setParameter('project', intval($teamId))
                ->getQuery()
                ->execute()
                ;
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return ShotsStatistics[] Returns an array of ShotsStatistics objects
    */
   public function findByTeamId($value): array
   {
       return $this->createQueryBuilder('s')
           ->Where('s.teamId = :val')
           ->setParameter('val', $value)
           ->orderBy('s.shotsCount', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

//    public function findOneBySomeField($value): ?ShotsStatistics
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
?>
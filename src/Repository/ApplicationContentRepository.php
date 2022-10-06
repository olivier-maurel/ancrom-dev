<?php

namespace App\Repository;

use App\Entity\ApplicationContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApplicationContent>
 *
 * @method ApplicationContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationContent[]    findAll()
 * @method ApplicationContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationContent::class);
    }

    public function add(ApplicationContent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApplicationContent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ApplicationContent[] Returns an array of ApplicationContent objects
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

//    public function findOneBySomeField($value): ?ApplicationContent
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

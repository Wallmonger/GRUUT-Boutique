<?php

namespace App\Repository;

use App\Entity\AuthorizationAvis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AuthorizationAvis>
 *
 * @method AuthorizationAvis|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuthorizationAvis|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuthorizationAvis[]    findAll()
 * @method AuthorizationAvis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuthorizationAvisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuthorizationAvis::class);
    }

    public function save(AuthorizationAvis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AuthorizationAvis $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
   /**
    * @return AuthorizationAvis[] Returns an array of AuthorizationAvis objects
    */


   

//    public function findOneBySomeField($value): ?AuthorizationAvis
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

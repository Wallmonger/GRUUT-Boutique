<?php

namespace App\Repository;

use App\Entity\MaterialsOfProduct;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MaterialsOfProduct>
 *
 * @method MaterialsOfProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialsOfProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialsOfProduct[]    findAll()
 * @method MaterialsOfProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialsOfProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialsOfProduct::class);
    }

    public function save(MaterialsOfProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MaterialsOfProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

/**
* @return MaterialsOfProduct[] Returns an array of MaterialsOfProduct objec
*/

    public function findMymaterials (Product $product) {
        $query = $this->createQueryBuilder('m');
        $query = $query
                ->andWhere('m.product = (:product)')
                ->setParameter('product', $product)
                ;
                return $query->getQuery()->getResult();
    }
    


//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MaterialsOfProduct
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Classe\Search;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }




    /**
     * Requête qui me permet de récupérer les produits en fonction de la recherche de l'utilisateur
     * @return Product[]
     */

   public function findWithSearch(Search $search) {

        
       $price = $search->price;
       $query = $this->createQueryBuilder('p');
        
        if (!empty($search->color)) {
           $query = $query
                ->andWhere('p.color IN (:color0)')
                ->setParameter('color0', $search->color)
                ;
        }
        
        if (!empty($search->price)) {
            $query = $query
                ->andWhere('p.price < (:price)')
                ->setParameter('price', ($price));
        }
        
        if (!empty($search->style)) {
            $query = $query
                ->andWhere('p.style IN (:style)')
                ->setParameter('style', $search->style);
        }

        

        

       
                                                  
        return $query->getQuery()->getResult();        # je demande à la fin de la fonction findWithSearch de me renvoyer le résultat de la requête                 
   }






//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

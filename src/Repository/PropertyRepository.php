<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

//    /**
//     * @return Property[]
//     */
//    public function getAllSoldFalse(): array
//    {
//        return $this->createQueryBuilder('p')
//            ->Where('p.sold = false')
//            ->getQuery()
//            ->getResult();
//    }

    /**
     * @return Query
     */
    public function getAllSoldFalse(PropertySearch $search): Query
    {
        $query = $this->findAllVisible();

        if($search->getMaxPrice())
        {
            $query =$query
                ->where('p.price <= :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }

        if($search->getMinSurface())
        {
            $query =$query
                ->where('p.price <= :minSurface')
                ->setParameter('minSurface', $search->getMinSurface());
        }

        if($search->getOptions()->count() > 0)
        {
            $k = 0;
            foreach($search->getOptions() as $k => $option){
                $k++;
                $query =$query
                    ->where(":option$k MEMBER OF p.options")
                    ->setParameter("option$k",$option);
            }

        }



        return $query->getQuery();
    }


    /**
     * @return Property[]
     */
    public function findLatest():array
    {
        return $this->findAllVisible()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    private function findAllVisible(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->Where('p.sold = false');
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}

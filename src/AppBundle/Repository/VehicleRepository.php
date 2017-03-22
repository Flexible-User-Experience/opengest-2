<?php

namespace AppBundle\Repository;

use AppBundle\Entity\VehicleCategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class VehicleRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class VehicleRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function findEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('v')
            ->where('v.enabled = :value')
            ->setParameter('value', true)
            ->orderBy('v.name', 'ASC')
        ;
    }

    /**
     * @return Query
     */
    public function findEnabledSortedByNameQ()
    {
        return $this->findEnabledSortedByNameQB()->getQuery();
    }

    /**
     * @return array
     */
    public function findEnabledSortedByName()
    {
        return $this->findEnabledSortedByNameQ()->getResult();
    }

    /**
     * @param VehicleCategory $category
     *
     * @return QueryBuilder
     */
    public function findEnabledSortedByNameFilterCategoryQB(VehicleCategory $category)
    {
        $qb = $this->findEnabledSortedByNameQB()
            ->join('v.category', 'vc')
            ->andWhere('v.category = :category')
            ->setParameter('category', $category)
        ;

        return $qb;
    }

    /**
     * @param VehicleCategory $category
     *
     * @return Query
     */
    public function findEnabledSortedByNameFilterCategoryQ(VehicleCategory $category)
    {
        return $this->findEnabledSortedByNameFilterCategoryQB($category)->getQuery();
    }

    /**
     * @param VehicleCategory $category
     *
     * @return array
     */
    public function findEnabledSortedByNameFilterCategory(VehicleCategory $category)
    {
        return $this->findEnabledSortedByNameFilterCategoryQ($category)->getResult();
    }
}

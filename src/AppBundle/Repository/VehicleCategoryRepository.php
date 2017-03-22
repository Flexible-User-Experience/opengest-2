<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class VehicleCategoryRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class VehicleCategoryRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function findEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('vc')
            ->where('vc.enabled = :value')
            ->setParameter('value', true)
            ->orderBy('vc.name', 'ASC')
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
}

<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ServiceRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ServiceRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function findEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('s')
            ->where('s.enabled = :value')
            ->setParameter('value', true)
            ->orderBy('s.name', 'ASC')
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
     * @return QueryBuilder
     */
    public function findEnabledSortedByPositionQB()
    {
        return $this->createQueryBuilder('s')
            ->where('s.enabled = :value')
            ->setParameter('value', true)
            ->orderBy('s.position', 'ASC')
        ;
    }

    /**
     * @return Query
     */
    public function findEnabledSortedByPositionQ()
    {
        return $this->findEnabledSortedByPositionQB()->getQuery();
    }

    /**
     * @return array
     */
    public function findEnabledSortedByPosition()
    {
        return $this->findEnabledSortedByPositionQ()->getResult();
    }
}

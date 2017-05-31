<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class WorkRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class WorkRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function findEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('w')
            ->where('w.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('w.name', 'ASC')
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
    public function findEnabledSortedByDateQB()
    {
        return $this->createQueryBuilder('w')
            ->where('w.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('w.date', 'DESC')
            ;
    }

    /**
     * @return Query
     */
    public function findEnabledSortedByDateQ()
    {
        return $this->findEnabledSortedByDateQB()->getQuery();
    }

    /**
     * @return array
     */
    public function findEnabledSortedByDate()
    {
        return $this->findEnabledSortedByDateQ()->getResult();
    }
}

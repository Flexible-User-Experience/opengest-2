<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class ComplementRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ComplementRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function findEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.name', 'ASC');
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

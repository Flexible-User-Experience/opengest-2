<?php

namespace AppBundle\Repository\Operator;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Class OperatorCheckingTypeRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias
 */
class OperatorCheckingTypeRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('oct')
            ->where('oct.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('oct.name', 'ASC')
        ;
    }

    /**
     * @return Query
     */
    public function getEnabledSortedByNameQ()
    {
        return $this->getEnabledSortedByNameQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getEnabledSortedByName()
    {
        return $this->getEnabledSortedByNameQ()->getResult();
    }
}

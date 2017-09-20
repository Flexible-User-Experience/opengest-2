<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Class OperatorCheckingRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias
 */
class OperatorCheckingRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getItemsBeforeToBeInvalidQB()
    {
        return $this->createQueryBuilder('oc')
            ->where('oc.enabled = :enabled')
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @return Query
     */
    public function getItemsBeforeToBeInvalidQ()
    {
        return $this->getItemsBeforeToBeInvalidQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getItemsBeforeToBeInvalid()
    {
        return $this->getItemsBeforeToBeInvalidQ()->getResult();
    }
}

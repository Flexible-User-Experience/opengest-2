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
        $thresholdDay = new \DateTime();
        $thresholdDay->add(new \DateInterval('P30D'));

        return $this->createQueryBuilder('oc')
            ->where('oc.end = :thresholdDay')
            ->setParameter('thresholdDay', $thresholdDay->format('Y-m-d'))
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

    /**
     * @return QueryBuilder
     */
    public function getItemsBeforeToBeInvalidSinceTodayQB()
    {
        $thresholdDay = new \DateTime();
        $thresholdDay->add(new \DateInterval('P30D'));

        return $this->createQueryBuilder('oc')
            ->where('oc.end <= :thresholdDay')
            ->andWhere('oc.end >= :today')
            ->setParameter('thresholdDay', $thresholdDay->format('Y-m-d'))
            ->setParameter('today', new \DateTime('now'))
        ;
    }

    /**
     * @return Query
     */
    public function getItemsBeforeToBeInvalidSinceTodayQ()
    {
        return $this->getItemsBeforeToBeInvalidSinceTodayQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getItemsBeforeToBeInvalidSinceToday()
    {
        return $this->getItemsBeforeToBeInvalidSinceTodayQ()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function getItemsInvalidQB()
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('oc')
            ->where('oc.end = :today')
            ->setParameter('today', $today->format('Y-m-d'))
        ;
    }

    /**
     * @return Query
     */
    public function getItemsInvalidQ()
    {
        return $this->getItemsInvalidQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getItemsInvalid()
    {
        return $this->getItemsInvalidQ()->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function getItemsInvalidSinceTodayQB()
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('oc')
            ->where('oc.end <= :today')
            ->setParameter('today', $today->format('Y-m-d'))
        ;
    }

    /**
     * @return Query
     */
    public function getItemsInvalidSinceTodayQ()
    {
        return $this->getItemsInvalidSinceTodayQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getItemsInvalidSinceToday()
    {
        return $this->getItemsInvalidSinceTodayQ()->getResult();
    }
}

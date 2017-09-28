<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Enterprise;
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
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQB(Enterprise $enterprise)
    {
        $thresholdDay = new \DateTime();
        $thresholdDay->add(new \DateInterval('P30D'));
        $today = new \DateTime();

        return $this->createQueryBuilder('oc')
            ->join('oc.operator', 'o')
            ->select('COUNT(oc.id)')
            ->where('oc.end <= :thresholdDay')
            ->andWhere('oc.end >= :today')
            ->andWhere('o.enterprise = :enterprise')
            ->setParameter('thresholdDay', $thresholdDay->format('Y-m-d'))
            ->setParameter('today', $today->format('Y-m-d'))
            ->setParameter('enterprise', $enterprise)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     */
    public function getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQ(Enterprise $enterprise)
    {
        return $this->getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     */
    public function getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
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
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmountQB(Enterprise $enterprise)
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('oc')
            ->join('oc.operator', 'o')
            ->select('COUNT(oc.id)')
            ->where('oc.end <= :today')
            ->andWhere('o.enterprise = :enterprise')
            ->setParameter('today', $today->format('Y-m-d'))
            ->setParameter('enterprise', $enterprise)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmountQ(Enterprise $enterprise)
    {
        return $this->getItemsInvalidSinceTodayByEnterpriseAmountQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsInvalidSinceTodayByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
    }
}

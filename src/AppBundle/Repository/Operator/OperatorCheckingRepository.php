<?php

namespace AppBundle\Repository\Operator;

use AppBundle\Entity\Enterprise\Enterprise;
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
     *
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidByEnabledOperatorQB()
    {
        $thresholdDay = new \DateTime();
        $thresholdDay->add(new \DateInterval('P30D'));

        return $this->createQueryBuilder('oc')
            ->join('oc.operator', 'o')
            ->where('oc.end = :thresholdDay')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('thresholdDay', $thresholdDay->format('Y-m-d'))
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @return Query
     *
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidByEnabledOperatorQ()
    {
        return $this->getItemsBeforeToBeInvalidByEnabledOperatorQB()->getQuery();
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidByEnabledOperator()
    {
        return $this->getItemsBeforeToBeInvalidByEnabledOperatorQ()->getResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     *
     * @throws \Exception
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
            ->andWhere('oc.end > :today')
            ->andWhere('o.enterprise = :enterprise')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('thresholdDay', $thresholdDay->format('Y-m-d'))
            ->setParameter('today', $today->format('Y-m-d'))
            ->setParameter('enterprise', $enterprise)
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     *
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQ(Enterprise $enterprise)
    {
        return $this->getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
    }

    /**
     * @return QueryBuilder
     *
     * @throws \Exception
     */
    public function getItemsInvalidByEnabledOperatorQB()
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('oc')
            ->join('oc.operator', 'o')
            ->where('oc.end = :today')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('today', $today->format('Y-m-d'))
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @return Query
     *
     * @throws \Exception
     */
    public function getItemsInvalidByEnabledOperatorQ()
    {
        return $this->getItemsInvalidByEnabledOperatorQB()->getQuery();
    }

    /**
     * @return array
     *
     * @throws \Exception
     */
    public function getItemsInvalidByEnabledOperator()
    {
        return $this->getItemsInvalidByEnabledOperatorQ()->getResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     *
     * @throws \Exception
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmountQB(Enterprise $enterprise)
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('oc')
            ->join('oc.operator', 'o')
            ->select('COUNT(oc.id)')
            ->where('oc.end <= :today')
            ->andWhere('o.enterprise = :enterprise')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('today', $today->format('Y-m-d'))
            ->setParameter('enterprise', $enterprise)
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     *
     * @throws \Exception
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmountQ(Enterprise $enterprise)
    {
        return $this->getItemsInvalidSinceTodayByEnterpriseAmountQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsInvalidSinceTodayByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
    }
}

<?php

namespace AppBundle\Repository\Vehicle;

use AppBundle\Entity\Enterprise;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Class VehicleCheckingRepository
 *
 * @category Repository
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class VehicleCheckingRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     * @throws \Exception
     */
    public function getItemsInvalidByEnabledVehicleQB()
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('vc')
            ->join('vc.vehicle', 'v')
            ->where('vc.end = :today')
            ->andWhere('v.enabled = :enabled')
            ->setParameter('today', $today->format('Y-m-d'))
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @return Query
     * @throws \Exception
     */
    public function getItemsInvalidByEnabledVehicleQ()
    {
        return $this->getItemsInvalidByEnabledVehicleQB()->getQuery();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getItemsInvalidByEnabledVehicle()
    {
        return $this->getItemsInvalidByEnabledVehicleQ()->getResult();
    }

    /**
     * @return QueryBuilder
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidByEnabledVehicleQB()
    {
        $thresholdDay = new \DateTime();
        $thresholdDay->add(new \DateInterval('P30D'));

        return $this->createQueryBuilder('vc')
            ->join('vc.vehicle', 'v')
            ->where('vc.end = :thresholdDay')
            ->andWhere('v.enabled = :enabled')
            ->setParameter('thresholdDay', $thresholdDay->format('Y-m-d'))
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @return Query
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidByEnabledVehicleQ()
    {
        return $this->getItemsBeforeToBeInvalidByEnabledVehicleQB()->getQuery();
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidByEnabledVehicle()
    {
        return $this->getItemsBeforeToBeInvalidByEnabledVehicleQ()->getResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     * @throws \Exception
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmountQB(Enterprise $enterprise)
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('vc')
            ->join('vc.vehicle', 'v')
            ->select('COUNT(vc.id)')
            ->where('vc.end <= :today')
            ->andWhere('v.enterprise = :enterprise')
            ->andWhere('v.enabled = :enabled')
            ->setParameter('today', $today->format('Y-m-d'))
            ->setParameter('enterprise', $enterprise)
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
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
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function getItemsInvalidSinceTodayByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsInvalidSinceTodayByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQB(Enterprise $enterprise)
    {
        $thresholdDay = new \DateTime();
        $thresholdDay->add(new \DateInterval('P30D'));
        $today = new \DateTime();

        return $this->createQueryBuilder('vc')
            ->join('vc.vehicle', 'v')
            ->select('COUNT(vc.id)')
            ->where('vc.end <= :thresholdDay')
            ->andWhere('vc.end > :today')
            ->andWhere('v.enterprise = :enterprise')
            ->andWhere('v.enabled = :enabled')
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
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsBeforeToBeInvalidSinceTodayByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
    }
}

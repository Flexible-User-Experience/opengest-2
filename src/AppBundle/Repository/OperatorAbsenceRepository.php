<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Enterprise;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Class OperatorAbsenceRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class OperatorAbsenceRepository extends EntityRepository
{
    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getItemsAbsenceTodayByEnterpriseAmountQB(Enterprise $enterprise)
    {
        $today = new \DateTime();

        return $this->createQueryBuilder('oa')
            ->join('oa.operator', 'o')
            ->select('COUNT(oa.id)')
            ->where('oa.begin <= :today')
            ->andWhere('oa.end >= :today')
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
     */
    public function getItemsAbsenceTodayByEnterpriseAmountQ(Enterprise $enterprise)
    {
        return $this->getItemsAbsenceTodayByEnterpriseAmountQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     */
    public function getItemsAbsenceTodayByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsAbsenceTodayByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getItemsToBeAbsenceTomorrowByEnterpriseAmountQB(Enterprise $enterprise)
    {
        $tomorrow = new \DateTime();
        $tomorrow->add(new \DateInterval('P1D'));

        return $this->createQueryBuilder('oa')
            ->join('oa.operator', 'o')
            ->select('COUNT(oa.id)')
            ->where('oa.begin = :tomorrow')
            ->andWhere('o.enterprise = :enterprise')
            ->andWhere('o.enabled = :enabled')
            ->setParameter('tomorrow', $tomorrow->format('Y-m-d'))
            ->setParameter('enterprise', $enterprise)
            ->setParameter('enabled', true)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     */
    public function getItemsToBeAbsenceTomorrowByEnterpriseAmountQ(Enterprise $enterprise)
    {
        return $this->getItemsToBeAbsenceTomorrowByEnterpriseAmountQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     */
    public function getItemsToBeAbsenceTomorrowByEnterpriseAmount(Enterprise $enterprise)
    {
        return $this->getItemsToBeAbsenceTomorrowByEnterpriseAmountQ($enterprise)->getSingleScalarResult();
    }
}

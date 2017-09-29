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
    public function getItemsAbsenceTodayAmountQB(Enterprise $enterprise)
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
    public function getItemsAbsenceTodayAmountQ(Enterprise $enterprise)
    {
        return $this->getItemsAbsenceTodayAmountQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     */
    public function getItemsAbsenceTodayAmount(Enterprise $enterprise)
    {
        return $this->getItemsAbsenceTodayAmountQ($enterprise)->getSingleScalarResult();
    }
}

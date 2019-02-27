<?php

namespace AppBundle\Repository\Sale;

use AppBundle\Entity\Enterprise\Enterprise;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class SaleRequestRepository.
 *
 * @category    Repository
 */
class SaleRequestRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByRequestDateQB()
    {
        return $this->createQueryBuilder('s')
            ->where('s.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('s.requestDate', 'DESC')
        ;
    }

    /**
     * @return Query
     */
    public function getEnabledSortedByRequestDateQ()
    {
        return $this->getEnabledSortedByRequestDateQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getEnabledSortedByRequestDate()
    {
        return $this->getEnabledSortedByRequestDateQ()->getResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getFilteredByEnterpriseEnabledSortedByRequestDateQB(Enterprise $enterprise)
    {
        return $this->getEnabledSortedByRequestDateQB()
            ->andWhere('s.enterprise = :enterprise')
            ->setParameter('enterprise', $enterprise)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     */
    public function getFilteredByEnterpriseEnabledSortedByRequestDateQ(Enterprise $enterprise)
    {
        return $this->getFilteredByEnterpriseEnabledSortedByRequestDateQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return array
     */
    public function getFilteredByEnterpriseEnabledSortedByRequestDate(Enterprise $enterprise)
    {
        return $this->getFilteredByEnterpriseEnabledSortedByRequestDateQ($enterprise)->getResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     *
     * @throws \Exception
     */
    public function getTodayFilteredByEnterpriseEnabledSortedByRequestDateQB(Enterprise $enterprise)
    {
        $moment = new \DateTime();

        return $this->commonGetTimeFilteredByEnterpriseEnabledSortedByRequestDateQB($enterprise, $moment);
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     *
     * @throws \Exception
     */
    public function getTodayFilteredByEnterpriseEnabledSortedByRequestDateQ(Enterprise $enterprise)
    {
        return $this->getTodayFilteredByEnterpriseEnabledSortedByRequestDateQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getTodayFilteredByEnterpriseEnabledSortedByRequestDate(Enterprise $enterprise)
    {
        return $this->getTodayFilteredByEnterpriseEnabledSortedByRequestDateQ($enterprise)->getResult();
    }

    // TODO getTomorrowFilteredByEnterpriseEnabledSortedByRequestDate
    // TODO getNextFilteredByEnterpriseEnabledSortedByRequestDate

    /**
     * @param Enterprise $enterprise
     * @param \DateTime  $moment
     *
     * @return QueryBuilder
     */
    private function commonGetTimeFilteredByEnterpriseEnabledSortedByRequestDateQB(Enterprise $enterprise, \DateTime $moment)
    {
        $qb = $this->getFilteredByEnterpriseEnabledSortedByRequestDateQB($enterprise)
            ->andWhere('DATE(s.requestDate) = DATE(:moment)')
            ->setParameter('moment', $moment)
        ;

        return $qb;
    }
}

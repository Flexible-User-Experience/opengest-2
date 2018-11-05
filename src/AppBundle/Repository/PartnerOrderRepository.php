<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PartnerOrderRepository.
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 */
class PartnerOrderRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByNumberQB()
    {
        return $this->createQueryBuilder('p')
            ->where('p.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('p.number', 'DESC')
        ;
    }

    /**
     * @return Query
     */
    public function getEnabledSortedByNumberQ()
    {
        return  $this->getEnabledSortedByNumberQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getEnabledSortedByNumber()
    {
        return $this->getEnabledSortedByNumberQ()->getResult();
    }
}

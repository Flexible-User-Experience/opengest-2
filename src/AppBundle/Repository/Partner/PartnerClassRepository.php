<?php

namespace AppBundle\Repository\Partner;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PartnerClassRepository.
 *
 * @category    Repository
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 */
class PartnerClassRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('p')
            ->where('p.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('p.name', 'ASC')
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

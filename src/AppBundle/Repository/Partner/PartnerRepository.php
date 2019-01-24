<?php

namespace AppBundle\Repository\Partner;

use AppBundle\Entity\Enterprise\Enterprise;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class PartnerRepository.
 *
 * @category    Repository
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 */
class PartnerRepository extends EntityRepository
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

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getFilteredByEnterpriseEnabledSortedByNameQB(Enterprise $enterprise)
    {
        return $this->getEnabledSortedByNameQB()
            ->andWhere('p.enterprise = :enterprise')
            ->setParameter('enterprise', $enterprise)
        ;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return Query
     */
    public function getFilteredByEnterpriseEnabledSortedByNameQ(Enterprise $enterprise)
    {
        return $this->getFilteredByEnterpriseEnabledSortedByNameQB($enterprise)->getQuery();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return array
     */
    public function getFilteredByEnterpriseEnabledSortedByName(Enterprise $enterprise)
    {
        return $this->getFilteredByEnterpriseEnabledSortedByNameQ($enterprise)->getResult();
    }
}

<?php

namespace AppBundle\Repository\Sale;

use AppBundle\Entity\Enterprise;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class SaleTariffRepository.
 *
 * @category    Repository
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 */
class SaleTariffRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('st')
            ->where('st.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('st.enterprise', 'ASC')
            ->addOrderBy('st.year', 'DESC')
            ->addOrderBy('st.tonnage', 'DESC')
        ;
    }

    /**
     * @return Query
     */
    public function getEnabledSortedByNameB()
    {
        return $this->getEnabledSortedByNameQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getEnabledSortedByName()
    {
        return $this->getEnabledSortedByNameB()->getResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getFilteredByEnterpriseEnabledSortedByNameQB(Enterprise $enterprise)
    {
        return $this->getEnabledSortedByNameQB()
            ->andWhere('st.enterprise = :enterprise')
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
     * @param Enterprise $enterpise
     *
     * @return array
     */
    public function getFilteredByEnterpriseEnabledSortedByName(Enterprise $enterpise)
    {
        return $this->getFilteredByEnterpriseEnabledSortedByNameQ($enterpise)->getResult();
    }
}

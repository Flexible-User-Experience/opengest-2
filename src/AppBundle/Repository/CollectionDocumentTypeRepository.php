<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Enterprise;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class CollectionDocumentTypeRepository.
 *
 * @category    Repository
 */
class CollectionDocumentTypeRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('c.name', 'ASC')
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
            ->andWhere('c.enterprise = :enterprise')
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

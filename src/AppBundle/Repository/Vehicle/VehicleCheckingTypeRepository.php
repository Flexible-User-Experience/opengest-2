<?php

namespace AppBundle\Repository\Vehicle;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Class VehicleCheckingTypeRepository.
 *
 * @catetory Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class VehicleCheckingTypeRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByNameQB()
    {
        return $this->createQueryBuilder('vct')
            ->where('vct.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('vct.name', 'ASC')
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

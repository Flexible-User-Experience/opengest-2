<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class     CityRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class CityRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getCitiesSortedByNameQB()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name')
        ;
    }

    /**
     * @return Query
     */
    public function getCitiesSortedByNameQ()
    {
        return $this->getCitiesSortedByNameQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getCitiesSortedByName()
    {
        return $this->getCitiesSortedByNameQ()->getResult();
    }
}

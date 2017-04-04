<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Work;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class WorkImageRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class WorkImageRepository extends EntityRepository
{
    /**
     * @param Work $work
     *
     * @return QueryBuilder
     */
    public function findEnabledSortedByPosition(Work $work)
    {
        return $this->createQueryBuilder('wi')
            ->where('wi.work = :work')
            ->andWhere('wi.enabled = :enabled')
            ->setParameter('work', $work)
            ->setParameter('value', true)
            ->orderBy('wi.position', 'ASC')
        ;
    }
}

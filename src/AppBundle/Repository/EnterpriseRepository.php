<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Class EnterpriseRepository.
 *
 * @category    Repository
 *
 * @author      Wils Iglesias <wiglesias83@gmail.com>
 */
class EnterpriseRepository extends EntityRepository
{
    /**
     * @param User $user
     *
     * @return QueryBuilder
     */
    public function getEnterprisesByUserQB(User $user)
    {
        return $this->createQueryBuilder('e')
            ->join('e.users', 'u')
            ->where('e.enabled = :value')
            ->andWhere('u.id = :id')
            ->setParameter('value', true)
            ->setParameter('id', $user->getId())
            ->orderBy('e.name', 'ASC')
        ;
    }

    /**
     * @param User $user
     *
     * @return Query
     */
    public function getEnterprisesByUserQ(User $user)
    {
        return $this->getEnterprisesByUserQB($user)->getQuery();
    }

    /**
     * @param User $user
     *
     * @return array
     */
    public function getEnterprisesByUser(User $user)
    {
        return $this->getEnterprisesByUserQ($user)->getResult();
    }
}

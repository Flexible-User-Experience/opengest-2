<?php

namespace AppBundle\Repository\Web;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query;

/**
 * Class ContactMessageRepository.
 *
 * @category Repository
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ContactMessageRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getPendingMessagesAmountQB()
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.answered = :answered')
            ->setParameter('answered', false)
        ;
    }

    /**
     * @return Query
     */
    public function getPendingMessagesAmountQ()
    {
        return $this->getPendingMessagesAmountQB()->getQuery();
    }

    /**
     * @return int|array
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getPendingMessagesAmount()
    {
        return $this->getPendingMessagesAmountQ()->getSingleScalarResult();
    }

    /**
     * @return QueryBuilder
     */
    public function getReadPendingMessagesAmountQB()
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->where('c.checked = :checked')
            ->setParameter('checked', false)
        ;
    }

    /**
     * @return Query
     */
    public function getReadPendingMessagesAmountQ()
    {
        return $this->getReadPendingMessagesAmountQB()->getQuery();
    }

    /**
     * @return int|array
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getReadPendingMessagesAmount()
    {
        return $this->getReadPendingMessagesAmountQ()->getSingleScalarResult();
    }
}

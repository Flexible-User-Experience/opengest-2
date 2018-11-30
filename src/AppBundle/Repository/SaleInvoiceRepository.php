<?php

namespace AppBundle\Repository;

use AppBundle\Entity\SaleInvoice;
use AppBundle\Entity\SaleInvoiceSeries;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class SaleInvoiceRepository.
 *
 * @category    Repository
 */
class SaleInvoiceRepository extends EntityRepository
{
    /**
     * @param SaleInvoiceSeries $saleInvoiceSeries
     *
     * @return QueryBuilder
     */
    public function getLastInvoiceBySerieQB(SaleInvoiceSeries $saleInvoiceSeries)
    {
        return $this->createQueryBuilder('s')
            ->where('s.series = :serie')
            ->setParameter('serie', $saleInvoiceSeries)
            ->orderBy('s.invoiceNumber', 'DESC')
            ->setMaxResults(1)
        ;
    }

    /**
     * @param SaleInvoiceSeries $saleInvoiceSeries
     *
     * @return Query
     */
    public function getLastInvoiceBySerieQ(SaleInvoiceSeries $saleInvoiceSeries)
    {
        return $this->getLastInvoiceBySerieQB($saleInvoiceSeries)->getQuery();
    }

    /**
     * @param SaleInvoiceSeries $saleInvoiceSeries
     *
     * @return SaleInvoice|null
     *
     * @throws NonUniqueResultException
     */
    public function getLastInvoiceBySerie(SaleInvoiceSeries $saleInvoiceSeries)
    {
        return $this->getLastInvoiceBySerieQ($saleInvoiceSeries)->getOneOrNullResult();
    }
}

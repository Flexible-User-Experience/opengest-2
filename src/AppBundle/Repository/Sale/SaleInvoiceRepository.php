<?php

namespace AppBundle\Repository\Sale;

use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Sale\SaleInvoice;
use AppBundle\Entity\Setting\SaleInvoiceSeries;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Class SaleInvoiceRepository.
 *
 * @category    Repository
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 */
class SaleInvoiceRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function getEnabledSortedByDateQB()
    {
        return $this->createQueryBuilder('s')
            ->where('s.enabled = :enabled')
            ->setParameter('enabled', true)
            ->orderBy('s.date', 'DESC')
        ;
    }

    /**
     * @return Query
     */
    public function gettEnabledSortedByDateQ()
    {
        return $this->getEnabledSortedByDateQB()->getQuery();
    }

    /**
     * @return array
     */
    public function getEnabledSortedByDate()
    {
        return $this->gettEnabledSortedByDateQ()->getResult();
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return QueryBuilder
     */
    public function getFilteredByEnterpriseSortedByDateQB(Enterprise $enterprise)
    {
        return $this->getEnabledSortedByDateQB()
            ->join('s.partner', 'p')
            ->andWhere('p.enterprise = :enterprise')
            ->setParameter('enterprise', $enterprise)
        ;
    }

    /**
     * @param SaleInvoiceSeries $saleInvoiceSeries
     * @param Enterprise        $enterprise
     *
     * @return QueryBuilder
     */
    public function getLastInvoiceBySerieAndEnterpriseQB(SaleInvoiceSeries $saleInvoiceSeries, Enterprise $enterprise)
    {
        return $this->getFilteredByEnterpriseSortedByDateQB($enterprise)
            ->andWhere('s.series = :serie')
            ->setParameter('serie', $saleInvoiceSeries)
            ->orderBy('s.invoiceNumber', 'DESC')
            ->setMaxResults(1)
        ;
    }

    /**
     * @param SaleInvoiceSeries $saleInvoiceSeries
     * @param Enterprise        $enterprise
     *
     * @return Query
     */
    public function getLastInvoiceBySerieAndEnterpriseB(SaleInvoiceSeries $saleInvoiceSeries, Enterprise $enterprise)
    {
        return $this->getLastInvoiceBySerieAndEnterpriseQB($saleInvoiceSeries, $enterprise)->getQuery();
    }

    /**
     * @param SaleInvoiceSeries $saleInvoiceSeries
     * @param Enterprise        $enterprise
     *
     * @return SaleInvoice|null
     *
     * @throws NonUniqueResultException
     */
    public function getLastInvoiceBySerieAndEnterprise(SaleInvoiceSeries $saleInvoiceSeries, Enterprise $enterprise)
    {
        return $this->getLastInvoiceBySerieAndEnterpriseB($saleInvoiceSeries, $enterprise)->getOneOrNullResult();
    }
}

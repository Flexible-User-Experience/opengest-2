<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Setting\SaleInvoiceSeries;
use AppBundle\Repository\Sale\SaleInvoiceRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class InvoiceManager.
 *
 * @category Manager
 **/
class InvoiceManager
{
    /**
     * @var SaleInvoiceRepository
     */
    private $saleInvoiceRepository;

    /**
     * Methods.
     */

    /**
     * InvoiceManager constructor.
     *
     * @param SaleInvoiceRepository $saleInvoiceRepository
     */
    public function __construct(SaleInvoiceRepository $saleInvoiceRepository)
    {
        $this->saleInvoiceRepository = $saleInvoiceRepository;
    }

    /**
     * @param SaleInvoiceSeries $serie
     * @param Enterprise        $enterprise
     *
     * @return int
     *
     * @throws NonUniqueResultException
     */
    public function getLastInvoiceNumberBySerieAndEnterprise(SaleInvoiceSeries $serie, Enterprise $enterprise)
    {
        $lastSaleInvoice = $this->saleInvoiceRepository->getLastInvoiceBySerieAndEnterprise($serie, $enterprise);

        return $lastSaleInvoice ? $lastSaleInvoice->getInvoiceNumber() + 1 : 1;
    }
}

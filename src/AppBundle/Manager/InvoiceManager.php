<?php

namespace AppBundle\Manager;

use AppBundle\Entity\SaleInvoiceSeries;
use AppBundle\Repository\SaleInvoiceRepository;

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
     *
     * @return int
     */
    public function getLastInvoiceNumberBySerie(SaleInvoiceSeries $serie)
    {
        return 3;
    }
}

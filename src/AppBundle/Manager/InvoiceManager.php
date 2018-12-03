<?php

namespace AppBundle\Manager;

use AppBundle\Entity\SaleInvoiceSeries;
use AppBundle\Repository\SaleInvoiceRepository;
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
     *
     * @throws NonUniqueResultException
     */
    public function getLastInvoiceNumberBySerie(SaleInvoiceSeries $serie)
    {
        $lastSaleInvoice = $this->saleInvoiceRepository->getLastInvoiceBySerie($serie);

        return $lastSaleInvoice ? $lastSaleInvoice->getInvoiceNumber() + 1 : 1;
    }
}

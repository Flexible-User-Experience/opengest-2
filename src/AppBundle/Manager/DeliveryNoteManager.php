<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Enterprise;
use AppBundle\Repository\Sale\SaleDeliveryNoteRepository;

/**
 * Class DeliveryNoteManager.
 *
 * @category Manager
 **/
class DeliveryNoteManager
{
    /**
     * @var SaleDeliveryNoteRepository
     */
    private $saleDeliveryNoteRepository;

    /**
     * DeliveryNoteManager constructor.
     *
     * @param SaleDeliveryNoteRepository $saleDeliveryNoteRepository
     */
    public function __construct(SaleDeliveryNoteRepository $saleDeliveryNoteRepository)
    {
        $this->saleDeliveryNoteRepository = $saleDeliveryNoteRepository;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return int
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLastDeliveryNoteByenterprise(Enterprise $enterprise)
    {
        $lastDeliveryNote = $this->saleDeliveryNoteRepository->getLastDeliveryNoteByenterprise($enterprise);

        return $lastDeliveryNote ? $lastDeliveryNote->getDeliveryNoteNumber() + 1 : 1;
    }
}

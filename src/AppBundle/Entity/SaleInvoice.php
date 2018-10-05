<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SaleInvoice.
 *
 * @category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleInvoiceRepository")
 * @ORM\Table(name="sale_invoice")
 */
class SaleInvoice extends AbstractBase
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SaleDeliveryNote", mappedBy="saleInvoice")
     */
    private $deliveryNotes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner")
     */
    private $partner;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $invoiceNumber;

    /**
     * @var SaleInvoiceSeries
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SaleInvoiceSeries")
     */
    private $series;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $total;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $hasBeenCounted = false;

    /**
     * SaleInvoice constructor.
     */
    public function __construct()
    {
        $this->deliveryNotes = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getDeliveryNotes()
    {
        return $this->deliveryNotes;
    }

    /**
     * @param ArrayCollection $deliveryNotes
     */
    public function setDeliveryNotes($deliveryNotes): void
    {
        $this->deliveryNotes = $deliveryNotes;
    }

    /**
     * @param SaleDeliveryNote $deliveryNote
     *
     * @return $this
     */
    public function addDeliveryNote($deliveryNote)
    {
        if (!$this->deliveryNotes->contains($deliveryNote)) {
            $this->deliveryNotes->add($deliveryNote);
            $deliveryNote->setSaleInvoice($this);
        }

        return $this;
    }

    /**
     * @param SaleDeliveryNote $deliveryNote
     *
     * @return $this
     */
    public function removeDeliveryNote($deliveryNote)
    {
        if ($this->deliveryNotes->contains($deliveryNote)) {
            $this->deliveryNotes->removeElement($deliveryNote);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param Partner $partner
     */
    public function setPartner($partner): void
    {
        $this->partner = $partner;
    }

    /**
     * @return int
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param int $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber): void
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return SaleInvoiceSeries
     */
    public function getSeries()
    {
        return $this->series;
    }

    /**
     * @param SaleInvoiceSeries $series
     */
    public function setSeries($series): void
    {
        $this->series = $series;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param float $total
     */
    public function setTotal($total): void
    {
        $this->total = $total;
    }

    /**
     * @return bool
     */
    public function isHasBeenCounted()
    {
        return $this->hasBeenCounted;
    }

    /**
     * @param bool $hasBeenCounted
     */
    public function setHasBeenCounted($hasBeenCounted): void
    {
        $this->hasBeenCounted = $hasBeenCounted;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getInvoiceNumber().' · '.$this->getPartner() : '---';
    }
}

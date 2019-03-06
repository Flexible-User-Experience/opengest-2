<?php

namespace AppBundle\Entity\Sale;

use AppBundle\Entity\AbstractBase;
use AppBundle\Entity\Partner\Partner;
use AppBundle\Entity\Setting\SaleInvoiceSeries;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class SaleInvoice.
 *
 * @category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Sale\SaleInvoiceRepository")
 * @ORM\Table(name="sale_invoice")
 */
class SaleInvoice extends AbstractBase
{
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sale\SaleDeliveryNote", mappedBy="saleInvoice")
     * @Groups({"api"})
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner\Partner")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Setting\SaleInvoiceSeries")
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
     * Methods.
     */

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
    public function setDeliveryNotes($deliveryNotes)
    {
        $this->deliveryNotes = $deliveryNotes;

        return $this;
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
            $deliveryNote->setSaleInvoice(null);
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
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
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
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
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
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullInvoiceNumber()
    {
        return ($this->getSeries() ? $this->getSeries()->getPrefix() : '???').'/'.$this->getInvoiceNumber();
    }

    /**
     * @return SaleInvoiceSeries
     */
    public function getSeries()
    {
        return $this->series;

        return $this;
    }

    /**
     * @param SaleInvoiceSeries $series
     */
    public function setSeries($series)
    {
        $this->series = $series;

        return $this;
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
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
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
    public function setHasBeenCounted($hasBeenCounted)
    {
        $this->hasBeenCounted = $hasBeenCounted;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getInvoiceNumber().' · '.$this->getPartner() : '---';
    }
}

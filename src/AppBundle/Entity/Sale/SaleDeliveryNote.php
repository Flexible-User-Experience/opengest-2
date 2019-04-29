<?php

namespace AppBundle\Entity\Sale;

use AppBundle\Entity\AbstractBase;
use AppBundle\Entity\Enterprise\ActivityLine;
use AppBundle\Entity\Enterprise\CollectionDocumentType;
use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Partner\Partner;
use AppBundle\Entity\Partner\PartnerBuildingSite;
use AppBundle\Entity\Partner\PartnerOrder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class SaleDeliveryNote.
 *
 * @category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Sale\SaleDeliveryNoteRepository")
 * @ORM\Table(name="sale_delivery_note")
 * @UniqueEntity({"enterprise", "deliveryNoteNumber"})
 */
class SaleDeliveryNote extends AbstractBase
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var Enterprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise\Enterprise")
     */
    private $enterprise;

    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner\Partner", inversedBy="saleDeliveryNotes")
     */
    private $partner;

    /**
     * @var PartnerBuildingSite
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner\PartnerBuildingSite")
     */
    private $buildingSite;

    /**
     * @var PartnerOrder
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner\PartnerOrder", inversedBy="saleDeliveryNotes")
     */
    private $order;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Groups({"api"})
     */
    private $deliveryNoteNumber;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     * @Groups({"api"})
     */
    private $baseAmount = 0;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $collectionTerm;

    /**
     * @var CollectionDocumentType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise\CollectionDocumentType")
     */
    private $collectionDocument;

    /**
     * @var ActivityLine
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise\ActivityLine")
     */
    private $activityLine;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $wontBeInvoiced = false;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Sale\SaleInvoice", mappedBy="deliveryNotes")
     */
    private $saleInvoices;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sale\SaleDeliveryNoteLine", mappedBy="deliveryNote", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $saleDeliveryNoteLines;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sale\SaleRequestHasDeliveryNote", mappedBy="saleDeliveryNote")
     */
    private $saleRequestHasDeliveryNotes;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Sale\SaleRequest", mappedBy="saleDeliveryNote")
     */
    private $saleRequests;

    /**
     * Methods.
     */

    /**
     * SaleDeliveryNote constructor.
     */
    public function __construct()
    {
        $this->saleInvoices = new ArrayCollection();
        $this->saleDeliveryNoteLines = new ArrayCollection();
        $this->saleRequestHasDeliveryNotes = new ArrayCollection();
        $this->saleRequests = new ArrayCollection();
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
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Enterprise
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * @param string $enterprise
     *
     * @return SaleDeliveryNote
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

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
     *
     * @return SaleDeliveryNote
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return PartnerBuildingSite
     */
    public function getBuildingSite()
    {
        return $this->buildingSite;
    }

    /**
     * @param PartnerBuildingSite $buildingSite
     *
     * @return SaleDeliveryNote
     */
    public function setBuildingSite($buildingSite)
    {
        $this->buildingSite = $buildingSite;

        return $this;
    }

    /**
     * @return PartnerOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param PartnerOrder $order
     *
     * @return SaleDeliveryNote
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return int
     */
    public function getDeliveryNoteNumber()
    {
        return $this->deliveryNoteNumber;
    }

    /**
     * @param int $deliveryNoteNumber
     *
     * @return SaleDeliveryNote
     */
    public function setDeliveryNoteNumber($deliveryNoteNumber)
    {
        $this->deliveryNoteNumber = $deliveryNoteNumber;

        return $this;
    }

    /**
     * @return float
     */
    public function getBaseAmount()
    {
        return $this->baseAmount;
    }

    /**
     * @param float $baseAmount
     *
     * @return SaleDeliveryNote
     */
    public function setBaseAmount($baseAmount)
    {
        $this->baseAmount = $baseAmount;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     *
     * @return SaleDeliveryNote
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCollectionTerm()
    {
        return $this->collectionTerm;
    }

    /**
     * @param int $collectionTerm
     *
     * @return SaleDeliveryNote
     */
    public function setCollectionTerm($collectionTerm)
    {
        $this->collectionTerm = $collectionTerm;

        return $this;
    }

    /**
     * @return CollectionDocumentType
     */
    public function getCollectionDocument()
    {
        return $this->collectionDocument;
    }

    /**
     * @param CollectionDocumentType $collectionDocument
     *
     * @return SaleDeliveryNote
     */
    public function setCollectionDocument($collectionDocument)
    {
        $this->collectionDocument = $collectionDocument;

        return $this;
    }

    /**
     * @return ActivityLine
     */
    public function getActivityLine()
    {
        return $this->activityLine;
    }

    /**
     * @param ActivityLine $activityLine
     *
     * @return SaleDeliveryNote
     */
    public function setActivityLine($activityLine)
    {
        $this->activityLine = $activityLine;

        return $this;
    }

    /**
     * @return bool
     */
    public function isWontBeInvoiced()
    {
        return $this->wontBeInvoiced;
    }

    /**
     * @param bool $wontBeInvoiced
     *
     * @return $this
     */
    public function setWontBeInvoiced($wontBeInvoiced)
    {
        $this->wontBeInvoiced = $wontBeInvoiced;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSaleInvoices()
    {
        return $this->saleInvoices;
    }

    /**
     * @param ArrayCollection $saleInvoices
     *
     * @return SaleDeliveryNote
     */
    public function setSaleInvoices(ArrayCollection $saleInvoices)
    {
        $this->saleInvoices = $saleInvoices;

        return $this;
    }

    /**
     * @param SaleInvoice $saleInvoice
     *
     * @return $this
     */
    public function addSaleInvoice(SaleInvoice $saleInvoice)
    {
        if (!$this->saleInvoices->contains($saleInvoice)) {
            $this->saleInvoices->add($saleInvoice);
        }

        return $this;
    }

    /**
     * @param SaleInvoice $saleInvoice
     *
     * @return $this
     */
    public function removeSaleInvoice(SaleInvoice $saleInvoice)
    {
        if ($this->saleInvoices->contains($saleInvoice)) {
            $this->saleInvoices->removeElement($saleInvoice);
            $saleInvoice->setDeliveryNotes(null);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSaleDeliveryNoteLines()
    {
        return $this->saleDeliveryNoteLines;
    }

    /**
     * @param ArrayCollection $SaleDeliveryNoteLines
     *
     * @return $this
     */
    public function setSaleDeliveryNoteLines($SaleDeliveryNoteLines)
    {
        $this->saleDeliveryNoteLines = $SaleDeliveryNoteLines;

        return $this;
    }

    /**
     * @param SaleDeliveryNoteLine $saleDeliveryNoteLine
     *
     * @return $this
     */
    public function addSaleDeliveryNoteLine(SaleDeliveryNoteLine $saleDeliveryNoteLine)
    {
        if (!$this->saleDeliveryNoteLines->contains($saleDeliveryNoteLine)) {
            $this->saleDeliveryNoteLines->add($saleDeliveryNoteLine);
            $saleDeliveryNoteLine->setDeliveryNote($this);
        }

        return $this;
    }

    /**
     * @param SaleDeliveryNoteLine $saleDeliveryNoteLine
     *
     * @return $this
     */
    public function removeSaleDeliveryNoteLine(SaleDeliveryNoteLine $saleDeliveryNoteLine)
    {
        if ($this->saleDeliveryNoteLines->contains($saleDeliveryNoteLine)) {
            $this->saleDeliveryNoteLines->removeElement($saleDeliveryNoteLine);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSaleRequestHasDeliveryNotes()
    {
        return $this->saleRequestHasDeliveryNotes;
    }

    /**
     * @param ArrayCollection $saleRequestHasDeliveryNotes
     *
     * @return $this
     */
    public function setSaleRequestHasDeliveryNotes($saleRequestHasDeliveryNotes)
    {
        $this->saleRequestHasDeliveryNotes = $saleRequestHasDeliveryNotes;

        return $this;
    }

    /**
     * @param SaleRequestHasDeliveryNote $saleRequestHasDeliveryNotes
     *
     * @return $this
     */
    public function addSaleRequestHasDeliveryNote($saleRequestHasDeliveryNotes)
    {
        if (!$this->saleRequestHasDeliveryNotes->contains($saleRequestHasDeliveryNotes)) {
            $this->saleRequestHasDeliveryNotes->add($saleRequestHasDeliveryNotes);
            $saleRequestHasDeliveryNotes->setSaleDeliveryNote($this);
        }

        return $this;
    }

    /**
     * @param SaleRequestHasDeliveryNote $saleRequestHasDeliveryNotes
     *
     * @return $this
     */
    public function removeRequestHasDeliveryNote($saleRequestHasDeliveryNotes)
    {
        if ($this->saleRequestHasDeliveryNotes->contains($saleRequestHasDeliveryNotes)) {
            $this->saleRequestHasDeliveryNotes->removeElement($saleRequestHasDeliveryNotes);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSaleRequests()
    {
        return $this->saleRequests;
    }

    /**
     * @param ArrayCollection $saleRequests
     *
     * @return $this
     */
    public function setSaleRequests(ArrayCollection $saleRequests)
    {
        $this->saleRequests = $saleRequests;

        return $this;
    }

    /**
     * @return string
     * @Groups({"api"})
     */
    public function getDateToString()
    {
        return $this->getDate()->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getDate()->format('d/m/Y').' · '.$this->getEnterprise().' · '.$this->getPartner() : '---';
    }
}

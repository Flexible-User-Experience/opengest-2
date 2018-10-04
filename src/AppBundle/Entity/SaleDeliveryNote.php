<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class SaleDeliveryNote.
 *
 * @category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleDeliveryNoteRepository")
 * @ORM\Table(name="sale_delivery_note")
 * @UniqueEntity({"enterprise", "deliveryNoteNumber"})
 */
class SaleDeliveryNote extends AbstractBase
{
    /**
     * @var datetime
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise")
     */
    private $enterprise;

    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner")
     */
    private $partner;

    /**
     * @var PartnerBuildingSite
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PartnerBuildingSite", nullable=true)
     */
    private $buildingSite;

    /**
     * @var PartnerOrder
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PartnerOrder", inversedBy="saleDeliveryNotes", nullable=true)
     */
    private $order;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $deliveryNoteNumber;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $baseAmount;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $collectionTerm;

    /**
     * @var CollectionDocumentType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CollectionDocumentType", nullable=true)
     */
    private $collectionDocument;

    /**
     * @var ActivityLine
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ActivityLine", nullable=true)
     */
    private $activityLine;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $wontBeInvoiced = false;

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * @param string $enterprise
     */
    public function setEnterprise($enterprise): void
    {
        $this->enterprise = $enterprise;
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
     * @return PartnerBuildingSite
     */
    public function getBuildingSite()
    {
        return $this->buildingSite;
    }

    /**
     * @param PartnerBuildingSite $buildingSite
     */
    public function setBuildingSite($buildingSite): void
    {
        $this->buildingSite = $buildingSite;
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
     */
    public function setOrder($order): void
    {
        $this->order = $order;
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
     */
    public function setDeliveryNoteNumber($deliveryNoteNumber): void
    {
        $this->deliveryNoteNumber = $deliveryNoteNumber;
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
     */
    public function setBaseAmount($baseAmount): void
    {
        $this->baseAmount = $baseAmount;
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
     */
    public function setDiscount($discount): void
    {
        $this->discount = $discount;
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
     */
    public function setCollectionTerm($collectionTerm): void
    {
        $this->collectionTerm = $collectionTerm;
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
     */
    public function setCollectionDocument($collectionDocument): void
    {
        $this->collectionDocument = $collectionDocument;
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
     */
    public function setActivityLine($activityLine): void
    {
        $this->activityLine = $activityLine;
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
     */
    public function setWontBeInvoiced($wontBeInvoiced): void
    {
        $this->wontBeInvoiced = $wontBeInvoiced;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getDate()->format('d/m/Y').' · '.$this->getEnterprise().' · '.$this->getPartner() : '---';
    }
}

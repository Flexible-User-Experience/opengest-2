<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SaleRequest.
 *
 * @category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleRequestRepository")
 * @ORM\Table(name="sale_request")
 */
class SaleRequest extends AbstractBase
{
    /**
     * @var Enterprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise", inversedBy="saleRequests")
     */
    private $enterprise;

    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner", inversedBy="saleRequests")
     */
    private $partner;

    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner")
     */
    private $invoiceTo;

    /**
     * @var Vehicle
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle", inversedBy="saleRequests")
     */
    private $vehicle;

    /**
     * @var Operator
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Operator", inversedBy="saleRequests")
     */
    private $operator;

    /**
     * @var SaleTariff
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SaleTariff")
     */
    private $tariff;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $attendedBy;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $serviceDescription;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $height;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $distance;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $utensils;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $observations;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $requestDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="time")
     */
    private $requestTime;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $hourPrice;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $miniumHours;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $displacement;

    /**
     * @var Vehicle
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle", nullable=true)
     */
    private $secondaryVehicle;

    /**
     * @return Enterprise
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return $this
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
     * @return $this
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return Partner
     */
    public function getInvoiceTo()
    {
        return $this->invoiceTo;
    }

    /**
     * @param Partner $invoiceTo
     *
     * @return $this
     */
    public function setInvoiceTo($invoiceTo)
    {
        $this->invoiceTo = $invoiceTo;

        return $this;
    }

    /**
     * @return Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle $vehicle
     *
     * @return $this
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return Operator
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @param Operator $operator
     *
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return SaleTariff
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * @param SaleTariff $tariff
     *
     * @return $this
     */
    public function setTariff($tariff)
    {
        $this->tariff = $tariff;

        return $this;
    }

    /**
     * @return User
     */
    public function getAttendedBy()
    {
        return $this->attendedBy;
    }

    /**
     * @param User $attendedBy
     *
     * @return $this
     */
    public function setAttendedBy($attendedBy)
    {
        $this->attendedBy = $attendedBy;

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceDescription()
    {
        return $this->serviceDescription;
    }

    /**
     * @param string $serviceDescription
     *
     * @return $this
     */
    public function setServiceDescription($serviceDescription)
    {
        $this->serviceDescription = $serviceDescription;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     *
     * @return $this
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     *
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     *
     * @return $this
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return string
     */
    public function getUtensils()
    {
        return $this->utensils;
    }

    /**
     * @param string $utensils
     *
     * @return $this
     */
    public function setUtensils($utensils)
    {
        $this->utensils = $utensils;

        return $this;
    }

    /**
     * @return string
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param string $observations
     *
     * @return $this
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRequestDate()
    {
        return $this->requestDate;
    }

    /**
     * @param \DateTime $requestDate
     *
     * @return $this
     */
    public function setRequestDate($requestDate)
    {
        $this->requestDate = $requestDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * @param \DateTime $requestTime
     *
     * @return $this
     */
    public function setRequestTime($requestTime)
    {
        $this->requestTime = $requestTime;

        return $this;
    }

    /**
     * @return float
     */
    public function getHourPrice()
    {
        return $this->hourPrice;
    }

    /**
     * @param float $hourPrice
     *
     * @return $this
     */
    public function setHourPrice($hourPrice)
    {
        $this->hourPrice = $hourPrice;

        return $this;
    }

    /**
     * @return float
     */
    public function getMiniumHours()
    {
        return $this->miniumHours;
    }

    /**
     * @param float $miniumHours
     *
     * @return $this
     */
    public function setMiniumHours($miniumHours)
    {
        $this->miniumHours = $miniumHours;

        return $this;
    }

    /**
     * @return float
     */
    public function getDisplacement()
    {
        return $this->displacement;
    }

    /**
     * @param float $displacement
     *
     * @return $this
     */
    public function setDisplacement($displacement)
    {
        $this->displacement = $displacement;

        return $this;
    }

    /**
     * @return Vehicle
     */
    public function getSecondaryVehicle()
    {
        return $this->secondaryVehicle;
    }

    /**
     * @param Vehicle $secondaryVehicle
     *
     * @return $this
     */
    public function setSecondaryVehicle($secondaryVehicle)
    {
        $this->secondaryVehicle = $secondaryVehicle;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getId().' · '.$this->getEnterprise() : '---';
    }
}

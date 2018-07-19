<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EnterpriseGroupBounty.
 *
 * @category Entity
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnterpriseGroupBountyRepository")
 * @ORM\Table(name="enterprise_group_bounty")
 */
class EnterpriseGroupBounty extends AbstractBase
{
    /**
     * @var Enterprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise", inversedBy="enterpriseGroupBounties")
     */
    private $enterprise;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="group_name")
     */
    private $group;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $normalHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $extraNormalHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $extraExtraHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $roadNormalHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $roadExtraHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $awaitingHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $negativeHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $transferHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $lunch;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $dinner;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $overNight;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $extraNight;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $diet;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $internationalLunch;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $internationalDinner;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $truckOutput;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true, options={"default"=0})
     */
    private $carOutput;

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
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     *
     * @return $this
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return float
     */
    public function getNormalHour()
    {
        return $this->normalHour;
    }

    /**
     * @param float $normalHour
     *
     * @return $this
     */
    public function setNormalHour($normalHour)
    {
        $this->normalHour = $normalHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getExtraNormalHour()
    {
        return $this->extraNormalHour;
    }

    /**
     * @param float $extraNormalHour
     *
     * @return $this
     */
    public function setExtraNormalHour($extraNormalHour)
    {
        $this->extraNormalHour = $extraNormalHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getExtraExtraHour()
    {
        return $this->extraExtraHour;
    }

    /**
     * @param float $extraExtraHour
     *
     * @return $this
     */
    public function setExtraExtraHour($extraExtraHour)
    {
        $this->extraExtraHour = $extraExtraHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getRoadNormalHour()
    {
        return $this->roadNormalHour;
    }

    /**
     * @param float $roadNormalHour
     *
     * @return $this
     */
    public function setRoadNormalHour($roadNormalHour)
    {
        $this->roadNormalHour = $roadNormalHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getRoadExtraHour()
    {
        return $this->roadExtraHour;
    }

    /**
     * @param float $roadExtraHour
     *
     * @return $this
     */
    public function setRoadExtraHour($roadExtraHour)
    {
        $this->roadExtraHour = $roadExtraHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getAwaitingHour()
    {
        return $this->awaitingHour;
    }

    /**
     * @param float $awaitingHour
     *
     * @return $this
     */
    public function setAwaitingHour($awaitingHour)
    {
        $this->awaitingHour = $awaitingHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getNegativeHour()
    {
        return $this->negativeHour;
    }

    /**
     * @param float $negativeHour
     *
     * @return $this
     */
    public function setNegativeHour($negativeHour)
    {
        $this->negativeHour = $negativeHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getTransferHour()
    {
        return $this->transferHour;
    }

    /**
     * @param float $transferHour
     *
     * @return $this
     */
    public function setTransferHour($transferHour)
    {
        $this->transferHour = $transferHour;

        return $this;
    }

    /**
     * @return float
     */
    public function getLunch()
    {
        return $this->lunch;
    }

    /**
     * @param float $lunch
     *
     * @return $this
     */
    public function setLunch($lunch)
    {
        $this->lunch = $lunch;

        return $this;
    }

    /**
     * @return float
     */
    public function getDinner()
    {
        return $this->dinner;
    }

    /**
     * @param float $dinner
     *
     * @return $this
     */
    public function setDinner($dinner)
    {
        $this->dinner = $dinner;

        return $this;
    }

    /**
     * @return float
     */
    public function getOverNight()
    {
        return $this->overNight;
    }

    /**
     * @param float $overNight
     *
     * @return $this
     */
    public function setOverNight($overNight)
    {
        $this->overNight = $overNight;

        return $this;
    }

    /**
     * @return float
     */
    public function getExtraNight()
    {
        return $this->extraNight;
    }

    /**
     * @param float $extraNight
     *
     * @return $this
     */
    public function setExtraNight($extraNight)
    {
        $this->extraNight = $extraNight;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiet()
    {
        return $this->diet;
    }

    /**
     * @param float $diet
     *
     * @return $this
     */
    public function setDiet($diet)
    {
        $this->diet = $diet;

        return $this;
    }

    /**
     * @return float
     */
    public function getInternationalLunch()
    {
        return $this->internationalLunch;
    }

    /**
     * @param float $internationalLunch
     *
     * @return $this
     */
    public function setInternationalLunch($internationalLunch)
    {
        $this->internationalLunch = $internationalLunch;

        return $this;
    }

    /**
     * @return float
     */
    public function getInternationalDinner()
    {
        return $this->internationalDinner;
    }

    /**
     * @param float $internationalDinner
     *
     * @return $this
     */
    public function setInternationalDinner($internationalDinner)
    {
        $this->internationalDinner = $internationalDinner;

        return $this;
    }

    /**
     * @return float
     */
    public function getTruckOutput()
    {
        return $this->truckOutput;
    }

    /**
     * @param float $truckOutput
     *
     * @return $this
     */
    public function setTruckOutput($truckOutput)
    {
        $this->truckOutput = $truckOutput;

        return $this;
    }

    /**
     * @return float
     */
    public function getCarOutput()
    {
        return $this->carOutput;
    }

    /**
     * @param float $carOutput
     *
     * @return $this
     */
    public function setCarOutput($carOutput)
    {
        $this->carOutput = $carOutput;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getGroup() : '---';
    }
}

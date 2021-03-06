<?php

namespace AppBundle\Entity\Sale;

use AppBundle\Entity\AbstractBase;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class SaleTariff.
 *
 * @category
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Sale\SaleTariffRepository")
 * @ORM\Table(name="sale_tariff")
 * @UniqueEntity({"enterprise", "year", "tonnage"})
 */
class SaleTariff extends AbstractBase
{
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise\Enterprise", inversedBy="saleTariffs")
     */
    private $enterprise;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $tonnage;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"apiSaleTariff"})
     */
    private $priceHour;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"apiSaleTariff"})
     */
    private $miniumHours;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $miniumHolidayHours;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"apiSaleTariff"})
     */
    private $displacement;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $increaseForHolidays;

    /**
     * Methods.
     */

    /**
     * @return string
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * @param string $enterprise
     *
     * @return $this
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     *
     * @return $this
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return string
     */
    public function getTonnage()
    {
        return $this->tonnage;
    }

    /**
     * @param string $tonnage
     *
     * @return $this
     */
    public function setTonnage($tonnage)
    {
        $this->tonnage = $tonnage;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceHour()
    {
        return $this->priceHour;
    }

    /**
     * @param float $priceHour
     *
     * @return $this
     */
    public function setPriceHour($priceHour)
    {
        $this->priceHour = $priceHour;

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
    public function getMiniumHolidayHours()
    {
        return $this->miniumHolidayHours;
    }

    /**
     * @param float $miniumHolidayHours
     *
     * @return $this
     */
    public function setMiniumHolidayHours($miniumHolidayHours)
    {
        $this->miniumHolidayHours = $miniumHolidayHours;

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
     * @return float
     */
    public function getIncreaseForHolidays()
    {
        return $this->increaseForHolidays;
    }

    /**
     * @param float $increaseForHolidays
     *
     * @return $this
     */
    public function setIncreaseForHolidays($increaseForHolidays)
    {
        $this->increaseForHolidays = $increaseForHolidays;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getEnterprise().' · '.$this->getYear().' · '.$this->getTonnage() : '---';
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class VehicleChecking
 *
 * @category Entity
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleCheckingRepository")
 * @ORM\Table(name="vehicle_checking")
 */
class VehicleChecking extends AbstractBase
{
    /**
     * @var Vehicle
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     */
    private $vehicle;

    /**
     * @var VehicleCheckingType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VehicleCheckingType")
     */
    private $type;

    /**
     * Methods.
     */

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $begin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $end;

    /**
     * @return Vehicle
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle $vehicle
     * @return VehicleChecking
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    /**
     * @return VehicleCheckingType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param VehicleCheckingType $type
     * @return VehicleChecking
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * @param \DateTime $begin
     *
     * @return VehicleChecking
     */
    public function setBegin(\DateTime $begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     *
     * @return VehicleChecking
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getBegin()->format('d/m/Y').' · '.$this->getType().' · '.$this->getVehicle() : '---';
    }
}

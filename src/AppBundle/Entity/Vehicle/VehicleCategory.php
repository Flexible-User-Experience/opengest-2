<?php

namespace AppBundle\Entity\Vehicle;

use AppBundle\Entity\AbstractBase;
use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\PositionTrait;
use AppBundle\Entity\Traits\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class VehicleCategory.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Vehicle\VehicleCategoryRepository")
 * @ORM\Table(name="vehicle_category")
 * @UniqueEntity({"name"})
 */
class VehicleCategory extends AbstractBase
{
    use NameTrait;
    use PositionTrait;
    use SlugTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vehicle\Vehicle", mappedBy="category")
     */
    private $vehicles;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Web\Service", mappedBy="vehicleCategory")
     */
    private $services;

    /**
     * Methods.
     */

    /**
     * VehicleCategory constructor.
     */
    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }

    /**
     * @param ArrayCollection $vehicles
     *
     * @return $this
     */
    public function setVehicles($vehicles)
    {
        $this->vehicles = $vehicles;

        return $this;
    }

    /**
     * @param Vehicle $vehicle
     *
     * @return $this
     */
    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles->add($vehicle);

        return $this;
    }

    /**
     * @param Vehicle $vehicle
     *
     * @return $this
     */
    public function removeVehicle(Vehicle $vehicle)
    {
        $this->vehicles->removeElement($vehicle);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param ArrayCollection $services
     *
     * @return VehicleCategory
     */
    public function setServices($services)
    {
        $this->services = $services;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getName() : '---';
    }
}

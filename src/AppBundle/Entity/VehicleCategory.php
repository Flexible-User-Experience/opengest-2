<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\PositionTrait;
use AppBundle\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Service.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleCategoryRepository")
 * @ORM\Table(name="vehicle_category")
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
     * @ORM\Column(type="string")
     */
    private $vehicles;

    /**
     * Methods.
     */

    /**
     * @return string
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }

    /**
     * @param string $vehicles
     *
     * @return VehicleCategory
     */
    public function setVehicles($vehicles)
    {
        $this->vehicles = $vehicles;

        return $this;
    }
}

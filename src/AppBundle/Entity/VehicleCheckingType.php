<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class VehicleCheckingType
 *
 * @category Entity
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleCheckingTypeRepository")
 * @ORM\Table(name="vehicle_checking_type")
 */
class VehicleCheckingType extends AbstractBase
{
    use NameTrait;

    /**
     * Method.
     */

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getName() : '---';
    }
}

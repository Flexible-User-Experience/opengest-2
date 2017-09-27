<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class OperatorAbsenceType.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OperatorAbsenceTypeRepository")
 * @ORM\Table(name="operator_absence_type")
 */
class OperatorAbsenceType extends AbstractBase
{
    use NameTrait;
    use DescriptionTrait;

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

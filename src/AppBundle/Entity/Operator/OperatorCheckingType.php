<?php

namespace AppBundle\Entity\Operator;

use AppBundle\Entity\AbstractBase;
use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class OperatorCheckingType.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 * 
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Operator\OperatorCheckingTypeRepository")
 * @ORM\Table(name="operator_checking_type")
 */
class OperatorCheckingType extends AbstractBase
{
    use NameTrait;
    use DescriptionTrait;

    /**
     * Methods.
     */

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getName() : '---';
    }
}

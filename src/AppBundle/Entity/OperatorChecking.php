<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OperatorChecking.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="operator_cheking")
 */
class OperatorChecking extends AbstractBase
{
    /**
     * @var Operator
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Operator")
     */
    private $operator;

    /**
     * @var OperatorCheckingType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OperatorCheckingType")
     */
    private $type;

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
     * Methods.
     */

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
     * @return OperatorChecking
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return OperatorCheckingType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param OperatorCheckingType $type
     *
     * @return OperatorChecking
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
     * @return OperatorChecking
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
     * @return OperatorChecking
     */
    public function setEnd(\DateTime $end)
    {
        $this->end = $end;

        return $this;
    }
}

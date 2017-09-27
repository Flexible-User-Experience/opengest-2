<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OperatorAbsence.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OperatorAbsenceRepository")
 * @ORM\Table(name="operator_absence")
 */
class OperatorAbsence extends AbstractBase
{
    /**
     * @var Operator
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Operator")
     */
    private $operator;

    /**
     * @var OperatorAbsenceType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OperatorAbsenceType")
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
     * @return OperatorAbsence
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return OperatorAbsenceType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param OperatorAbsenceType $type
     *
     * @return OperatorAbsence
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
     * @return OperatorAbsence
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
     * @return OperatorAbsence
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
        return $this->id ? $this->getBegin()->format('d/m/Y').' · '.$this->getType().' · '.$this->getOperator() : '---';
    }
}

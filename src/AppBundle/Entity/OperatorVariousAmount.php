<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OperatorVariousAmount.
 *
 * @category Entity
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OperatorVariousAmountRepository")
 * @ORM\Table(name="operator_various_amount")
 */
class OperatorVariousAmount extends AbstractBase
{
    /**
     * @var Operator
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Operator", inversedBy="operatorVariousAmount")
     */
    private $operator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $units;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    private $priceUnit;

    /**d
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
     * @return $this
     */
    public function setOperator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param int $units
     *
     * @return $this
     */
    public function setUnits($units)
    {
        $this->units = $units;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float
     */
    public function getPriceUnit()
    {
        return $this->priceUnit;
    }

    /**
     * @param float $priceUnit
     *
     * @return $this
     */
    public function setPriceUnit($priceUnit)
    {
        $this->priceUnit = $priceUnit;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getOperator()->getName().' - '.$this->getDate()->format('d/m/Y').' : '.$this->getDescription() : '---';
    }
}

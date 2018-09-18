<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class EnterpriseHolidays.
 *
 * @category
 **
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnterpriseHolidaysRepository")
 * @ORM\Table(name="enterprise-holidays")
 */
class EnterpriseHolidays extends AbstractBase
{
    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise", inversedBy="enterpriseHolidays")
     */
    private $enterprise;

    /**
     * @var \DateTime
     */
    private $day;

    /**
     * @var string
     *
     * @ORM\Column(type="string, nullable=true")
     */
    private $name;

    /**
     * @return string
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * Methods.
     */

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
     * @return \DateTime
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param \DateTime $day
     *
     * @return $this
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getDay()->format('d/m/Y').' · '.$this->getName() : '---';
    }
}

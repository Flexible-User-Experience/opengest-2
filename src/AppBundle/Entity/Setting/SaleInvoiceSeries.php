<?php

namespace AppBundle\Entity\Setting;

use AppBundle\Entity\AbstractBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SaleInvoiceSeries.
 *
 * @category Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Setting\SaleInvoiceSeriesRepository")
 * @ORM\Table(name="sale_invoice_series")
 */
class SaleInvoiceSeries extends AbstractBase
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $prefix;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $isDefault = false;

    /**
     * Methods
     */

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * @param string $prefix
     */
    public function setPrefix($prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return bool
     */
    public function isDefault()
    {
        return $this->isDefault;
    }

    /**
     * @param bool $isDefault
     */
    public function setIsDefault($isDefault): void
    {
        $this->isDefault = $isDefault;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getName().' · '.$this->getPrefix() : '---';
    }
}

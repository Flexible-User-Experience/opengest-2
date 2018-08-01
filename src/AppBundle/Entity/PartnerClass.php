<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class PartnerClass.
 *
 * @category Entity
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartnerClassRepository")
 * @ORM\Table(name="partner_class")
 */
class PartnerClass extends AbstractBase
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Partner", mappedBy="class")
     */
    private $partners;

    /**
     * Methods.
     */

    /**
     * PartnerClass constructor.
     */
    public function __construct()
    {
        $this->partners = new ArrayCollection();
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
     * @return ArrayCollection
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * @param ArrayCollection $partners
     *
     * @return $this
     */
    public function setPartners($partners)
    {
        $this->partners = $partners;

        return $this;
    }

    /**
     * @param Partner $partner
     *
     * @return $this
     */
    public function addPartner($partner)
    {
        if (!$this->partners->contains($partner)) {
            $this->partners->add($partner);
            $partner->setClass($this);
        }

        return $this;
    }

    /**
     * @param Partner $partner
     *
     * @return $this
     */
    public function removePartner($partner)
    {
        if ($this->partners->contains($partner)) {
            $this->partners->remove($partner);
        }

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

<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Service.
 *
 * @category Entity
 *
 * @author Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServiceRepository")
 * @ORM\Table(name="service")
 */
class Service extends AbstractBase
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true, options={"default"=0})
     */
    private $position = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=4000, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $mainImage;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Work", mappedBy="service")
     */
    private $works;

    /**
     * Methods.
     */

    /**
     * Service constructor.
     */
    public function __construct()
    {
        $this->works = new ArrayCollection();
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
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param int $position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;

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
     * @return string
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param string $mainImage
     *
     * @return $this
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getWorks()
    {
        return $this->works;
    }

    /**
     * @param ArrayCollection $works
     *
     * @return $this
     */
    public function setWorks($works)
    {
        $this->works = $works;

        return $this;
    }

    /**
     * @param Work $work
     *
     * @return $this
     */
    public function addWork(Work $work)
    {
        $this->works[] = $work;

        return $this;
    }

    /**
     * @param Work $work
     *
     * @return $this
     */
    public function removeWork(Work $work)
    {
        $this->works->removeElement($work);

        return $this;
    }
}

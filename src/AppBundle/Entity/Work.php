<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Work.
 *
 * @category
 *
 * @author Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkRepository")
 * @ORM\Table(name="work")
 */
class Work extends AbstractBase
{
    /**
     * @var Service
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Service", inversedBy="works")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $shortDescription;

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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\WorkImage", mappedBy="work")
     */
    private $images;

    /**
     * Methods.
     */

    /**
     * Work constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param Service $service
     *
     * @return $this
     */
    public function setService($service)
    {
        $this->service = $service;

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
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     *
     * @return $this
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;

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
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param ArrayCollection $images
     *
     * @return $this
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param WorkImage $workImage
     *
     * @return $this
     */
    public function addImage(WorkImage $workImage)
    {
        $workImage->setImage($this);
        $this->images->add($workImage);

        return $this;
    }

    /**
     * @param WorkImage $workImage
     *
     * @return $this
     */
    public function removeImage(WorkImage $workImage)
    {
        $this->images->removeElement($workImage);

        return $this;
    }
}

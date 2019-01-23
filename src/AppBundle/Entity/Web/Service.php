<?php

namespace AppBundle\Entity\Web;

use AppBundle\Entity\AbstractBase;
use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\PositionTrait;
use AppBundle\Entity\Traits\SlugTrait;
use AppBundle\Entity\Vehicle\VehicleCategory;
use AppBundle\Entity\Work;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Service.
 *
 * @category Entity
 *
 * @author Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Web\ServiceRepository")
 * @ORM\Table(name="service")
 * @Vich\Uploadable
 * @UniqueEntity({"name"})
 */
class Service extends AbstractBase
{
    use SlugTrait;
    use PositionTrait;
    use DescriptionTrait;
    use NameTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="service", fileNameProperty="mainImage")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $mainImageFile;

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
     * @var VehicleCategory
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\VehicleCategory", inversedBy="services")
     * @ORM\JoinColumn(name="vehicle_category_id", referencedColumnName="id")
     */
    private $vehicleCategory;

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
     * @return File
     */
    public function getMainImageFile()
    {
        return $this->mainImageFile;
    }

    /**
     * @param File|null $mainImageFile
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setMainImageFile(File $mainImageFile = null)
    {
        $this->mainImageFile = $mainImageFile;
        if ($mainImageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

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
        $this->works->add($work);

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

    /**
     * @return VehicleCategory
     */
    public function getVehicleCategory()
    {
        return $this->vehicleCategory;
    }

    /**
     * @param VehicleCategory $vehicleCategory
     *
     * @return Service
     */
    public function setVehicleCategory($vehicleCategory)
    {
        $this->vehicleCategory = $vehicleCategory;

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

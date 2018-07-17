<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class VehicleDigitalTachograph.
 *
 * @category
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleDigitalTachographRepository")
 * @ORM\Table(name="vehicle_digital_tachograph")
 * @Vich\Uploadable()
 */
class VehicleDigitalTachograph extends AbstractBase
{
    /**
     * @var Operator
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle", inversedBy="vehicleDigitalTachographs")
     */
    private $vehicle;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="digital_tachograph_vehicle", fileNameProperty="uploadedFileName")
     * @Assert\File(maxSize="10M")
     */
    private $uploadedFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $uploadedFileName;

    /**
     * Methods.
     */

    /**
     * @return Operator
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param Operator $vehicle
     *
     * @return $this
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return File
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }

    /**
     * @param File $uploadedFile
     *
     * @return $this
     */
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getUploadedFileName()
    {
        return $this->uploadedFileName;
    }

    /**
     * @param string $uploadedFileName
     *
     * @return $this
     */
    public function setUploadedFileName($uploadedFileName)
    {
        $this->uploadedFileName = $uploadedFileName;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getCreatedAt()->format('d/m/Y').' · '.$this->getVehicle() : '---';
    }
}

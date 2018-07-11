<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class DigitalTachograph.
 *
 * @category
 *
 * @author Rubèn Hierro <info@rubenhierro.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DigitalTachographRepository")
 * @ORM\Table(name="digital_tachograph")
 * @Vich\Uploadable()
 */
class DigitalTachograph extends AbstractBase
{
    /**
     * @var Operator
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Operator", inversedBy="digitalTachographs")
     */
    private $operator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $uploadedDate;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="digital_tachograph_operator", fileNameProperty="uploadedFileName")
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
    public function getUploadedDate()
    {
        return $this->uploadedDate;
    }

    /**
     * @param \DateTime $uploadedDate
     *
     * @return $this
     */
    public function setUploadedDate($uploadedDate)
    {
        $this->uploadedDate = $uploadedDate;

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
        return $this->id ? $this->getUploadedDate()->format('d/m/Y').' · '.$this->getOperator() : '---';
    }
}

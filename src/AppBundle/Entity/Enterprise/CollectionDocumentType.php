<?php

namespace AppBundle\Entity\Enterprise;

use AppBundle\Entity\AbstractBase;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CollectionDocumentType.
 *
 * @category Entity
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Enterprise\CollectionDocumentTypeRepository")
 * @ORM\Table(name="collection_document_type")
 */
class CollectionDocumentType extends AbstractBase
{
    /**
     * @var Enterprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise\Enterprise", inversedBy="collectionDocumentTypes")
     */
    private $enterprise;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $sitReference;

    /**
     * Methods.
     */

    /**
     * @return Enterprise
     */
    public function getEnterprise(): Enterprise
    {
        return $this->enterprise;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return $this
     */
    public function setEnterprise(Enterprise $enterprise): CollectionDocumentType
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     *
     * @return $this
     */
    public function setName(?string $name): CollectionDocumentType
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     *
     * @return $this
     */
    public function setDescription(?string $description): CollectionDocumentType
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSitReference(): ?string
    {
        return $this->sitReference;
    }

    /**
     * @param string|null $sitReference
     *
     * @return $this
     */
    public function setSitReference(?string $sitReference): CollectionDocumentType
    {
        $this->sitReference = $sitReference;

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

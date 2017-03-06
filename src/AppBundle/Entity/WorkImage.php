<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Class WorkImage
 *
 * @category Entity
 * @package AppBundle\Entity
 * @author Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="work_image")
 */
class WorkImage extends AbstractBase
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Work", inversedBy="images")
     * @ORM\JoinColumn(name="work_id", referencedColumnName="id")
     */
    private $work;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $high;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true, options={"default"=0})
     */
    private $position = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $image;

    /**
     *
     * Methods
     *
     */

    /**
     * @return mixed
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @param mixed $work
     *
     * @return $this
     *
     */
    public function setWork($work)
    {
        $this->work = $work;

        return $this;
    }

    /**
     * @return string
     */
    public function getHigh()
    {
        return $this->high;
    }

    /**
     * @param string $high
     *
     * @return $this
     */
    public function setHigh($high)
    {
        $this->high = $high;

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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
}

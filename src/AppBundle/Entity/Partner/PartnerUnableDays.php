<?php

namespace AppBundle\Entity\Partner;

use AppBundle\Entity\AbstractBase;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class PartnerUnableDays.
 *
 * @category Entity
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Partner\PartnerUnableDaysRepository")
 * @ORM\Table(name="partner_unable_days")
 */
class PartnerUnableDays extends AbstractBase
{
    /**
     * @var Partner
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Partner\Partner", inversedBy="partnerUnableDays")
     */
    private $partner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $begin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date")
     */
    private $end;

    /**
     * Methods.
     */

    /**
     * @return Partner
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param Partner $partner
     *
     * @return $this
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * @param \DateTime $begin
     *
     * @return $this
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     *
     * @return $this
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getEnd() < $this->getBegin()) {
            $context
                ->buildViolation('La data fi de ser més gran que la data d\'inici')
                ->atPath('end')
                ->addViolation();
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getPartner()->getName().' : '.$this->getBegin()->format('d/m/Y') : '---';
    }
}

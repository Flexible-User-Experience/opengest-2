<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Enterprise.
 *
 * @category    Entity
 *
 * @author      Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="enterprise")
 * @UniqueEntity({"taxIdentificationNumber"})
 */
class Enterprise extends AbstractBase
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
     * @ORM\Column(type="string")
     */
    private $taxIdentificationNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $businessName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phone3;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $wwww;

    /**
     * @ORM\Column(type="string")
     */
    private $logo;

    /**
     * @ORM\Column(type="string")
     */
    private $deedOfIncorporation;

    /**
     * @ORM\Column(type="string")
     */
    private $taxIdentificationNumberCard;

    /**
     * @ORM\Column(type="string")
     */
    private $tc1Receipt;

    /**
     * @ORM\Column(type="string")
     */
    private $tc2Receipt;

    /**
     * @ORM\Column(type="string")
     */
    private $ssRegistration;

    /**
     * @ORM\Column(type="string")
     */
    private $rc1Insurance;

    /**
     * @ORM\Column(type="string")
     */
    private $rc2Insurance;

    /**
     * @ORM\Column(type="string")
     */
    private $rcReceipt;

    /**
     * @ORM\Column(type="string")
     */
    private $preventionServiceContract;

    /**
     * @ORM\Column(type="string")
     */
    private $preventionServiceInvoice;

    /**
     * @ORM\Column(type="string")
     */
    private $preventionServiceReceipt;

    /**
     * @ORM\Column(type="string")
     */
    private $occupationalAccidentsInsurance;

    /**
     * @ORM\Column(type="string")
     */
    private $occupationalReceipt;

    /**
     * @ORM\Column(type="string")
     */
    private $laborRiskAssessment;

    /**
     * @ORM\Column(type="string")
     */
    private $securityPlan;

    /**
     * @ORM\Column(type="string")
     */
    private $reaCertificate;

    /**
     * @ORM\Column(type="string")
     */
    private $oilCertificate;

    /**
     * @ORM\Column(type="string")
     */
    private $gencatPaymentCertificate;

    /**
     * @ORM\Column(type="string")
     */
    private $deedsOfPowers;

    /**
     * @ORM\Column(type="string")
     */
    private $iaeRegistration;

    /**
     * @ORM\Column(type="string")
     */
    private $iaeReceipt;

    /**
     * @ORM\Column(type="string")
     */
    private $mutualPartnership;
}

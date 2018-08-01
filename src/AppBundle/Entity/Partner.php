<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Partner.
 *
 * @category Entity
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartnerRepository")
 * @ORM\Table(name="partner")
 */
class Partner extends AbstractBase
{
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $cifNif;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Enterprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise", inversedBy="partners")
     */
    private $enterprise;

    /**
     * @var PartnerClass
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PartnerClass", inversedBy="partners")
     */
    private $class;

    /**
     * @var PartnerType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PartnerType", inversedBy="partners")
     */
    private $type;

    /**
     * @var EnterpriseTransferAccount
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EnterpriseTransferAccount", inversedBy="partners")
     */
    private $transferAccount;

    /**
     * @var string
     *
     * @ORM\Column(type="text", length=4000, nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $mainAddress;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     */
    private $mainCity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $secondaryAddress;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     */
    private $secondaryCity;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber4;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phoneNumber5;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $faxNumber1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $faxNumber2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $www;

    /**
     * @var float
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $providerReference;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $reference;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ivaTaxFree;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $iban;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $swift;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $bankCode;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $officeNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $controlDigit;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accountNumber;

    /**
     * Methods.
     */

    /**
     * @return string
     */
    public function getCifNif()
    {
        return $this->cifNif;
    }

    /**
     * @param string $cifNif
     *
     * @return $this
     */
    public function setCifNif($cifNif)
    {
        $this->cifNif = $cifNif;

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
     * @return Enterprise
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * @param Enterprise $enterprise
     *
     * @return $this
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    /**
     * @return PartnerClass
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param PartnerClass $class
     *
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return PartnerType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param PartnerType $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return EnterpriseTransferAccount
     */
    public function getTransferAccount()
    {
        return $this->transferAccount;
    }

    /**
     * @param EnterpriseTransferAccount $transferAccount
     *
     * @return $this
     */
    public function setTransferAccount($transferAccount)
    {
        $this->transferAccount = $transferAccount;

        return $this;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     *
     * @return $this
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return string
     */
    public function getMainAddress()
    {
        return $this->mainAddress;
    }

    /**
     * @param string $mainAddress
     *
     * @return $this
     */
    public function setMainAddress($mainAddress)
    {
        $this->mainAddress = $mainAddress;

        return $this;
    }

    /**
     * @return City
     */
    public function getMainCity()
    {
        return $this->mainCity;
    }

    /**
     * @param City $mainCity
     *
     * @return $this
     */
    public function setMainCity($mainCity)
    {
        $this->mainCity = $mainCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getSecondaryAddress()
    {
        return $this->secondaryAddress;
    }

    /**
     * @param string $secondaryAddress
     *
     * @return $this
     */
    public function setSecondaryAddress($secondaryAddress)
    {
        $this->secondaryAddress = $secondaryAddress;

        return $this;
    }

    /**
     * @return City
     */
    public function getSecondaryCity()
    {
        return $this->secondaryCity;
    }

    /**
     * @param City $secondaryCity
     *
     * @return $this
     */
    public function setSecondaryCity($secondaryCity)
    {
        $this->secondaryCity = $secondaryCity;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber1()
    {
        return $this->phoneNumber1;
    }

    /**
     * @param string $phoneNumber1
     *
     * @return $this
     */
    public function setPhoneNumber1($phoneNumber1)
    {
        $this->phoneNumber1 = $phoneNumber1;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber2()
    {
        return $this->phoneNumber2;
    }

    /**
     * @param string $phoneNumber2
     *
     * @return $this
     */
    public function setPhoneNumber2($phoneNumber2)
    {
        $this->phoneNumber2 = $phoneNumber2;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber3()
    {
        return $this->phoneNumber3;
    }

    /**
     * @param string $phoneNumber3
     *
     * @return $this
     */
    public function setPhoneNumber3($phoneNumber3)
    {
        $this->phoneNumber3 = $phoneNumber3;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber4()
    {
        return $this->phoneNumber4;
    }

    /**
     * @param string $phoneNumber4
     *
     * @return $this
     */
    public function setPhoneNumber4($phoneNumber4)
    {
        $this->phoneNumber4 = $phoneNumber4;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber5()
    {
        return $this->phoneNumber5;
    }

    /**
     * @param string $phoneNumber5
     *
     * @return $this
     */
    public function setPhoneNumber5($phoneNumber5)
    {
        $this->phoneNumber5 = $phoneNumber5;

        return $this;
    }

    /**
     * @return string
     */
    public function getFaxNumber1()
    {
        return $this->faxNumber1;
    }

    /**
     * @param string $faxNumber1
     *
     * @return $this
     */
    public function setFaxNumber1($faxNumber1)
    {
        $this->faxNumber1 = $faxNumber1;

        return $this;
    }

    /**
     * @return string
     */
    public function getFaxNumber2()
    {
        return $this->faxNumber2;
    }

    /**
     * @param string $faxNumber2
     *
     * @return $this
     */
    public function setFaxNumber2($faxNumber2)
    {
        $this->faxNumber2 = $faxNumber2;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getWww()
    {
        return $this->www;
    }

    /**
     * @param string $www
     *
     * @return $this
     */
    public function setWww($www)
    {
        $this->www = $www;

        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     *
     * @return $this
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     *
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getProviderReference()
    {
        return $this->providerReference;
    }

    /**
     * @param string $providerReference
     *
     * @return $this
     */
    public function setProviderReference($providerReference)
    {
        $this->providerReference = $providerReference;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return $this
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return bool
     */
    public function isIvaTaxFree()
    {
        return $this->ivaTaxFree;
    }

    /**
     * @param bool $ivaTaxFree
     *
     * @return $this
     */
    public function setIvaTaxFree($ivaTaxFree)
    {
        $this->ivaTaxFree = $ivaTaxFree;

        return $this;
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     *
     * @return $this
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * @return string
     */
    public function getSwift()
    {
        return $this->swift;
    }

    /**
     * @param string $swift
     *
     * @return $this
     */
    public function setSwift($swift)
    {
        $this->swift = $swift;

        return $this;
    }

    /**
     * @return string
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }

    /**
     * @param string $bankCode
     *
     * @return $this
     */
    public function setBankCode($bankCode)
    {
        $this->bankCode = $bankCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getOfficeNumber()
    {
        return $this->officeNumber;
    }

    /**
     * @param string $officeNumber
     *
     * @return $this
     */
    public function setOfficeNumber($officeNumber)
    {
        $this->officeNumber = $officeNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getControlDigit()
    {
        return $this->controlDigit;
    }

    /**
     * @param string $controlDigit
     *
     * @return $this
     */
    public function setControlDigit($controlDigit)
    {
        $this->controlDigit = $controlDigit;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param string $accountNumber
     *
     * @return $this
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

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

<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Operator.
 *
 * @author Wils Iglesias <wiglesias83@gmail.com>
 * @ORM\Entity
 * @ORM\Table(name="operator")
 * @UniqueEntity({"enterprise", "taxIdentificationNumber"})
 */
class Operator extends AbstractBase
{
    use NameTrait;

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
    private $bancAccountNumber;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $socialSecurityNumber;

    /**
     * @var float
     *
     * @ORM\Column(type="string")
     */
    private $hourCost;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $surname1;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $surname2;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var Enterprise
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Enterprise")
     */
    private $enterprise;

    /**
     * @var City
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\City")
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $enterpriseMobile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $ownPhone;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $ownMobile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $brithDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $profilePhotoImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $taxIdentificationNumberImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $drivingLicenseImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $cranesOperatorLicenseImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $medicalCheckImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $episImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $trainingDocumentImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $informationImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $useOfMachineryAuthorizationImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $dischargeSocialSecurityImage;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $employmentContractImage;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $hasCarDrivingLicense = true;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $hasLorryDrivingLicense = true;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $hasTowingDrivingLicense = false;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $hasCraneDrivingLicense = false;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $shoeSize;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $jerseytSize;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $jacketSize;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $tShirtSize;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $pantSize;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $workingDressSize;

    /**
     * @return string
     */
    public function getTaxIdentificationNumber()
    {
        return $this->taxIdentificationNumber;
    }

    /**
     * @param string $taxIdentificationNumber
     *
     * @return Operator
     */
    public function setTaxIdentificationNumber($taxIdentificationNumber)
    {
        $this->taxIdentificationNumber = $taxIdentificationNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getBancAccountNumber()
    {
        return $this->bancAccountNumber;
    }

    /**
     * @param string $bancAccountNumber
     *
     * @return Operator
     */
    public function setBancAccountNumber($bancAccountNumber)
    {
        $this->bancAccountNumber = $bancAccountNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getSocialSecurityNumber()
    {
        return $this->socialSecurityNumber;
    }

    /**
     * @param string $socialSecurityNumber
     *
     * @return Operator
     */
    public function setSocialSecurityNumber($socialSecurityNumber)
    {
        $this->socialSecurityNumber = $socialSecurityNumber;

        return $this;
    }

    /**
     * @return float
     */
    public function getHourCost()
    {
        return $this->hourCost;
    }

    /**
     * @param float $hourCost
     *
     * @return Operator
     */
    public function setHourCost($hourCost)
    {
        $this->hourCost = $hourCost;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname1()
    {
        return $this->surname1;
    }

    /**
     * @param string $surname1
     *
     * @return Operator
     */
    public function setSurname1($surname1)
    {
        $this->surname1 = $surname1;

        return $this;
    }

    /**
     * @return string
     */
    public function getSurname2()
    {
        return $this->surname2;
    }

    /**
     * @param string $surname2
     *
     * @return Operator
     */
    public function setSurname2($surname2)
    {
        $this->surname2 = $surname2;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return Operator
     */
    public function setAddress($address)
    {
        $this->address = $address;

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
     * @return Operator
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    /**
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param City $city
     *
     * @return Operator
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnterpriseMobile()
    {
        return $this->enterpriseMobile;
    }

    /**
     * @param string $enterpriseMobile
     *
     * @return Operator
     */
    public function setEnterpriseMobile($enterpriseMobile)
    {
        $this->enterpriseMobile = $enterpriseMobile;

        return $this;
    }

    /**
     * @return string
     */
    public function getOwnPhone()
    {
        return $this->ownPhone;
    }

    /**
     * @param string $ownPhone
     *
     * @return Operator
     */
    public function setOwnPhone($ownPhone)
    {
        $this->ownPhone = $ownPhone;

        return $this;
    }

    /**
     * @return string
     */
    public function getOwnMobile()
    {
        return $this->ownMobile;
    }

    /**
     * @param string $ownMobile
     *
     * @return Operator
     */
    public function setOwnMobile($ownMobile)
    {
        $this->ownMobile = $ownMobile;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBrithDate()
    {
        return $this->brithDate;
    }

    /**
     * @param \DateTime $brithDate
     *
     * @return Operator
     */
    public function setBrithDate($brithDate)
    {
        $this->brithDate = $brithDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param \DateTime $registrationDate
     *
     * @return Operator
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getProfilePhotoImage()
    {
        return $this->profilePhotoImage;
    }

    /**
     * @param string $profilePhotoImage
     *
     * @return Operator
     */
    public function setProfilePhotoImage($profilePhotoImage)
    {
        $this->profilePhotoImage = $profilePhotoImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getTaxIdentificationNumberImage()
    {
        return $this->taxIdentificationNumberImage;
    }

    /**
     * @param string $taxIdentificationNumberImage
     *
     * @return Operator
     */
    public function setTaxIdentificationNumberImage($taxIdentificationNumberImage)
    {
        $this->taxIdentificationNumberImage = $taxIdentificationNumberImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getDrivingLicenseImage()
    {
        return $this->drivingLicenseImage;
    }

    /**
     * @param string $drivingLicenseImage
     *
     * @return Operator
     */
    public function setDrivingLicenseImage($drivingLicenseImage)
    {
        $this->drivingLicenseImage = $drivingLicenseImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getCranesOperatorLicenseImage()
    {
        return $this->cranesOperatorLicenseImage;
    }

    /**
     * @param string $cranesOperatorLicenseImage
     *
     * @return Operator
     */
    public function setCranesOperatorLicenseImage($cranesOperatorLicenseImage)
    {
        $this->cranesOperatorLicenseImage = $cranesOperatorLicenseImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getMedicalCheckImage()
    {
        return $this->medicalCheckImage;
    }

    /**
     * @param string $medicalCheckImage
     *
     * @return Operator
     */
    public function setMedicalCheckImage($medicalCheckImage)
    {
        $this->medicalCheckImage = $medicalCheckImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getEpisImage()
    {
        return $this->episImage;
    }

    /**
     * @param string $episImage
     *
     * @return Operator
     */
    public function setEpisImage($episImage)
    {
        $this->episImage = $episImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrainingDocumentImage()
    {
        return $this->trainingDocumentImage;
    }

    /**
     * @param string $trainingDocumentImage
     *
     * @return Operator
     */
    public function setTrainingDocumentImage($trainingDocumentImage)
    {
        $this->trainingDocumentImage = $trainingDocumentImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getInformationImage()
    {
        return $this->informationImage;
    }

    /**
     * @param string $informationImage
     *
     * @return Operator
     */
    public function setInformationImage($informationImage)
    {
        $this->informationImage = $informationImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getUseOfMachineryAuthorizationImage()
    {
        return $this->useOfMachineryAuthorizationImage;
    }

    /**
     * @param string $useOfMachineryAuthorizationImage
     *
     * @return Operator
     */
    public function setUseOfMachineryAuthorizationImage($useOfMachineryAuthorizationImage)
    {
        $this->useOfMachineryAuthorizationImage = $useOfMachineryAuthorizationImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getDischargeSocialSecurityImage()
    {
        return $this->dischargeSocialSecurityImage;
    }

    /**
     * @param string $dischargeSocialSecurityImage
     *
     * @return Operator
     */
    public function setDischargeSocialSecurityImage($dischargeSocialSecurityImage)
    {
        $this->dischargeSocialSecurityImage = $dischargeSocialSecurityImage;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmploymentContractImage()
    {
        return $this->employmentContractImage;
    }

    /**
     * @param string $employmentContractImage
     *
     * @return Operator
     */
    public function setEmploymentContractImage($employmentContractImage)
    {
        $this->employmentContractImage = $employmentContractImage;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHasCarDrivingLicense()
    {
        return $this->hasCarDrivingLicense;
    }

    /**
     * @param bool $hasCarDrivingLicense
     *
     * @return Operator
     */
    public function setHasCarDrivingLicense($hasCarDrivingLicense)
    {
        $this->hasCarDrivingLicense = $hasCarDrivingLicense;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHasLorryDrivingLicense()
    {
        return $this->hasLorryDrivingLicense;
    }

    /**
     * @param bool $hasLorryDrivingLicense
     *
     * @return Operator
     */
    public function setHasLorryDrivingLicense($hasLorryDrivingLicense)
    {
        $this->hasLorryDrivingLicense = $hasLorryDrivingLicense;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHasTowingDrivingLicense()
    {
        return $this->hasTowingDrivingLicense;
    }

    /**
     * @param bool $hasTowingDrivingLicense
     *
     * @return Operator
     */
    public function setHasTowingDrivingLicense($hasTowingDrivingLicense)
    {
        $this->hasTowingDrivingLicense = $hasTowingDrivingLicense;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHasCraneDrivingLicense()
    {
        return $this->hasCraneDrivingLicense;
    }

    /**
     * @param bool $hasCraneDrivingLicense
     *
     * @return Operator
     */
    public function setHasCraneDrivingLicense($hasCraneDrivingLicense)
    {
        $this->hasCraneDrivingLicense = $hasCraneDrivingLicense;

        return $this;
    }

    /**
     * @return int
     */
    public function getShoeSize()
    {
        return $this->shoeSize;
    }

    /**
     * @param int $shoeSize
     *
     * @return Operator
     */
    public function setShoeSize($shoeSize)
    {
        $this->shoeSize = $shoeSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getJerseytSize()
    {
        return $this->jerseytSize;
    }

    /**
     * @param int $jerseytSize
     *
     * @return Operator
     */
    public function setJerseytSize($jerseytSize)
    {
        $this->jerseytSize = $jerseytSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getJacketSize()
    {
        return $this->jacketSize;
    }

    /**
     * @param int $jacketSize
     *
     * @return Operator
     */
    public function setJacketSize($jacketSize)
    {
        $this->jacketSize = $jacketSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getTShirtSize()
    {
        return $this->tShirtSize;
    }

    /**
     * @param int $tShirtSize
     *
     * @return Operator
     */
    public function setTShirtSize($tShirtSize)
    {
        $this->tShirtSize = $tShirtSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getPantSize()
    {
        return $this->pantSize;
    }

    /**
     * @param int $pantSize
     *
     * @return Operator
     */
    public function setPantSize($pantSize)
    {
        $this->pantSize = $pantSize;

        return $this;
    }

    /**
     * @return int
     */
    public function getWorkingDressSize()
    {
        return $this->workingDressSize;
    }

    /**
     * @param int $workingDressSize
     *
     * @return Operator
     */
    public function setWorkingDressSize($workingDressSize)
    {
        $this->workingDressSize = $workingDressSize;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getEnterprise().' · '.$this->getTaxIdentificationNumber() : '---';
    }
}

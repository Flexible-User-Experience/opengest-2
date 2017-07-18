<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Enterprise.
 *
 * @category    Entity
 *
 * @author      Wils Iglesias <wiglesias83@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnterpriseRepository")
 * @ORM\Table(name="enterprise")
 * @Vich\Uploadable()
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\Email(strict=true, checkMX=true, checkHost=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $www;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="logo")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=300)
     */
    private $logoFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $logo;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="deedOfIncorporation")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $deedOfIncorporationFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $deedOfIncorporation;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="taxIdentificationNumberCard")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $taxIdentificationNumberCardFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $taxIdentificationNumberCard;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="tc1Receipt")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $tc1ReceiptFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $tc1Receipt;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="tc2Receipt")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $tc2ReceiptFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $tc2Receipt;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="ssRegistration")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $ssRegistrationFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $ssRegistration;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="ssPaymentCertificate")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $ssPaymentCertificateFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $ssPaymentCertificate;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="rc1Insurance")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $rc1InsuranceFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $rc1Insurance;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="rc2Insurance")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $rc2InsuranceFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $rc2Insurance;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="rcReceipt")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $rcReceiptFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $rcReceipt;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="preventionServiceContract")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $preventionServiceContractFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $preventionServiceContract;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="preventionServiceInvoice")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $preventionServiceInvoiceFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $preventionServiceInvoice;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="preventionServiceReceipt")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $preventionServiceReceiptFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $preventionServiceReceipt;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="occupationalAccidentsInsurance")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $occupationalAccidentsInsuranceFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $occupationalAccidentsInsurance;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="occupationalReceipt")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $occupationalReceiptFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $occupationalReceipt;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="laborRiskAssessment")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $laborRiskAssessmentFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $laborRiskAssessment;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="securityPlan")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $securityPlanFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $securityPlan;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="reaCertificate")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $reaCertificateFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $reaCertificate;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="oilCertificate")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $oilCertificateFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $oilCertificate;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="gencatPaymentCertificate")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $gencatPaymentCertificateFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $gencatPaymentCertificate;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="deedsOfPowers")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $deedsOfPowersFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $deedsOfPowers;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="iaeRegistration")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $iaeRegistrationFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $iaeRegistration;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="iaeReceipt")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $iaeReceiptFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $iaeReceipt;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="enterprise", fileNameProperty="mutualPartnership")
     * @Assert\File(
     *     maxSize="10M",
     *     mimeTypes={"image/jpg", "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf"}
     * )
     * @Assert\Image(minWidth=1200)
     */
    private $mutualPartnershipFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $mutualPartnership;

    /**
     * Methods.
     */

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
     * @return Enterprise
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

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
     * @return Enterprise
     */
    public function setTaxIdentificationNumber($taxIdentificationNumber)
    {
        $this->taxIdentificationNumber = $taxIdentificationNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getBusinessName()
    {
        return $this->businessName;
    }

    /**
     * @param string $businessName
     *
     * @return Enterprise
     */
    public function setBusinessName($businessName)
    {
        $this->businessName = $businessName;

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
     * @return Enterprise
     */
    public function setAddress($address)
    {
        $this->address = $address;

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
     * @return Enterprise
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone1()
    {
        return $this->phone1;
    }

    /**
     * @param string $phone1
     *
     * @return Enterprise
     */
    public function setPhone1($phone1)
    {
        $this->phone1 = $phone1;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone2()
    {
        return $this->phone2;
    }

    /**
     * @param string $phone2
     *
     * @return Enterprise
     */
    public function setPhone2($phone2)
    {
        $this->phone2 = $phone2;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhone3()
    {
        return $this->phone3;
    }

    /**
     * @param string $phone3
     *
     * @return Enterprise
     */
    public function setPhone3($phone3)
    {
        $this->phone3 = $phone3;

        return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param string $fax
     *
     * @return Enterprise
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

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
     * @return Enterprise
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
     * @return Enterprise
     */
    public function setWww($www)
    {
        $this->www = $www;

        return $this;
    }

    /**
     * @return File
     */
    public function getLogoFile()
    {
        return $this->logoFile;
    }

    /**
     * @param File|null $logoFile
     *
     * @return Enterprise
     */
    public function setLogoFile(File $logoFile = null)
    {
        $this->logoFile = $logoFile;
        if ($logoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     *
     * @return Enterprise
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return File
     */
    public function getDeedOfIncorporationFile()
    {
        return $this->deedOfIncorporationFile;
    }

    /**
     * @param File|null $deedOfIncorporationFile
     *
     * @return Enterprise
     */
    public function setDeedOfIncorporationFile(File $deedOfIncorporationFile = null)
    {
        $this->deedOfIncorporationFile = $deedOfIncorporationFile;
        if ($deedOfIncorporationFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDeedOfIncorporation()
    {
        return $this->deedOfIncorporation;
    }

    /**
     * @param string $deedOfIncorporation
     *
     * @return Enterprise
     */
    public function setDeedOfIncorporation($deedOfIncorporation)
    {
        $this->deedOfIncorporation = $deedOfIncorporation;

        return $this;
    }

    /**
     * @return File
     */
    public function getTaxIdentificationNumberCardFile()
    {
        return $this->taxIdentificationNumberCardFile;
    }

    /**
     * @param File|null $taxIdentificationNumberCardFile
     *
     * @return Enterprise
     */
    public function setTaxIdentificationNumberCardFile(File $taxIdentificationNumberCardFile = null)
    {
        $this->taxIdentificationNumberCardFile = $taxIdentificationNumberCardFile;
        if ($taxIdentificationNumberCardFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTaxIdentificationNumberCard()
    {
        return $this->taxIdentificationNumberCard;
    }

    /**
     * @param string $taxIdentificationNumberCard
     *
     * @return Enterprise
     */
    public function setTaxIdentificationNumberCard($taxIdentificationNumberCard)
    {
        $this->taxIdentificationNumberCard = $taxIdentificationNumberCard;

        return $this;
    }

    /**
     * @return File
     */
    public function getTc1ReceiptFile()
    {
        return $this->tc1ReceiptFile;
    }

    /**
     * @param File|null $tc1ReceiptFile
     *
     * @return Enterprise
     */
    public function setTc1ReceiptFile(File $tc1ReceiptFile = null)
    {
        $this->tc1ReceiptFile = $tc1ReceiptFile;
        if ($tc1ReceiptFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTc1Receipt()
    {
        return $this->tc1Receipt;
    }

    /**
     * @param string $tc1Receipt
     *
     * @return Enterprise
     */
    public function setTc1Receipt($tc1Receipt)
    {
        $this->tc1Receipt = $tc1Receipt;

        return $this;
    }

    /**
     * @return File
     */
    public function getTc2ReceiptFile()
    {
        return $this->tc2ReceiptFile;
    }

    /**
     * @param File|null $tc2ReceiptFile
     *
     * @return Enterprise
     */
    public function setTc2ReceiptFile(File $tc2ReceiptFile = null)
    {
        $this->tc2ReceiptFile = $tc2ReceiptFile;
        if ($tc2ReceiptFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getTc2Receipt()
    {
        return $this->tc2Receipt;
    }

    /**
     * @param string $tc2Receipt
     *
     * @return Enterprise
     */
    public function setTc2Receipt($tc2Receipt)
    {
        $this->tc2Receipt = $tc2Receipt;

        return $this;
    }

    /**
     * @return File
     */
    public function getSsRegistrationFile()
    {
        return $this->ssRegistrationFile;
    }

    /**
     * @param File|null $ssRegistrationFile
     *
     * @return Enterprise
     */
    public function setSsRegistrationFile(File $ssRegistrationFile = null)
    {
        $this->ssRegistrationFile = $ssRegistrationFile;
        if ($ssRegistrationFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSsRegistration()
    {
        return $this->ssRegistration;
    }

    /**
     * @param string $ssRegistration
     *
     * @return Enterprise
     */
    public function setSsRegistration($ssRegistration)
    {
        $this->ssRegistration = $ssRegistration;

        return $this;
    }

    /**
     * @return File
     */
    public function getSsPaymentCertificateFile()
    {
        return $this->ssPaymentCertificateFile;
    }

    /**
     * @param File|null $ssPaymentCertificateFile
     *
     * @return Enterprise
     */
    public function setSsPaymentCertificateFile(File $ssPaymentCertificateFile = null)
    {
        $this->ssPaymentCertificateFile = $ssPaymentCertificateFile;
        if ($ssPaymentCertificateFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSsPaymentCertificate()
    {
        return $this->ssPaymentCertificate;
    }

    /**
     * @param string $ssPaymentCertificate
     *
     * @return Enterprise
     */
    public function setSsPaymentCertificate($ssPaymentCertificate)
    {
        $this->ssPaymentCertificate = $ssPaymentCertificate;

        return $this;
    }

    /**
     * @return File
     */
    public function getRc1InsuranceFile()
    {
        return $this->rc1InsuranceFile;
    }

    /**
     * @param File|null $rc1InsuranceFile
     *
     * @return Enterprise
     */
    public function setRc1InsuranceFile(File $rc1InsuranceFile = null)
    {
        $this->rc1InsuranceFile = $rc1InsuranceFile;
        if ($rc1InsuranceFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRc1Insurance()
    {
        return $this->rc1Insurance;
    }

    /**
     * @param string $rc1Insurance
     *
     * @return Enterprise
     */
    public function setRc1Insurance($rc1Insurance)
    {
        $this->rc1Insurance = $rc1Insurance;

        return $this;
    }

    /**
     * @return File
     */
    public function getRc2InsuranceFile()
    {
        return $this->rc2InsuranceFile;
    }

    /**
     * @param File|null $rc2InsuranceFile
     *
     * @return Enterprise
     */
    public function setRc2InsuranceFile(File $rc2InsuranceFile = null)
    {
        $this->rc2InsuranceFile = $rc2InsuranceFile;
        if ($rc2InsuranceFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRc2Insurance()
    {
        return $this->rc2Insurance;
    }

    /**
     * @param string $rc2Insurance
     *
     * @return Enterprise
     */
    public function setRc2Insurance($rc2Insurance)
    {
        $this->rc2Insurance = $rc2Insurance;

        return $this;
    }

    /**
     * @return File
     */
    public function getRcReceiptFile()
    {
        return $this->rcReceiptFile;
    }

    /**
     * @param File|null $rcReceiptFile
     *
     * @return Enterprise
     */
    public function setRcReceiptFile(File $rcReceiptFile = null)
    {
        $this->rcReceiptFile = $rcReceiptFile;
        if ($rcReceiptFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRcReceipt()
    {
        return $this->rcReceipt;
    }

    /**
     * @param string $rcReceipt
     *
     * @return Enterprise
     */
    public function setRcReceipt($rcReceipt)
    {
        $this->rcReceipt = $rcReceipt;

        return $this;
    }

    /**
     * @return File
     */
    public function getPreventionServiceContractFile()
    {
        return $this->preventionServiceContractFile;
    }

    /**
     * @param File|null $preventionServiceContractFile
     *
     * @return Enterprise
     */
    public function setPreventionServiceContractFile(File $preventionServiceContractFile = null)
    {
        $this->preventionServiceContractFile = $preventionServiceContractFile;
        if ($preventionServiceContractFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPreventionServiceContract()
    {
        return $this->preventionServiceContract;
    }

    /**
     * @param string $preventionServiceContract
     *
     * @return Enterprise
     */
    public function setPreventionServiceContract($preventionServiceContract)
    {
        $this->preventionServiceContract = $preventionServiceContract;

        return $this;
    }

    /**
     * @return File
     */
    public function getPreventionServiceInvoiceFile()
    {
        return $this->preventionServiceInvoiceFile;
    }

    /**
     * @param File|null $preventionServiceInvoiceFile
     *
     * @return Enterprise
     */
    public function setPreventionServiceInvoiceFile(File $preventionServiceInvoiceFile = null)
    {
        $this->preventionServiceInvoiceFile = $preventionServiceInvoiceFile;
        if ($preventionServiceInvoiceFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPreventionServiceInvoice()
    {
        return $this->preventionServiceInvoice;
    }

    /**
     * @param string $preventionServiceInvoice
     *
     * @return Enterprise
     */
    public function setPreventionServiceInvoice($preventionServiceInvoice)
    {
        $this->preventionServiceInvoice = $preventionServiceInvoice;

        return $this;
    }

    /**
     * @return File
     */
    public function getPreventionServiceReceiptFile()
    {
        return $this->preventionServiceReceiptFile;
    }

    /**
     * @param File|null $preventionServiceReceiptFile
     *
     * @return Enterprise
     */
    public function setPreventionServiceReceiptFile(File $preventionServiceReceiptFile = null)
    {
        $this->preventionServiceReceiptFile = $preventionServiceReceiptFile;
        if ($this->preventionServiceReceiptFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPreventionServiceReceipt()
    {
        return $this->preventionServiceReceipt;
    }

    /**
     * @param string $preventionServiceReceipt
     *
     * @return Enterprise
     */
    public function setPreventionServiceReceipt($preventionServiceReceipt)
    {
        $this->preventionServiceReceipt = $preventionServiceReceipt;

        return $this;
    }

    /**
     * @return File
     */
    public function getOccupationalAccidentsInsuranceFile()
    {
        return $this->occupationalAccidentsInsuranceFile;
    }

    /**
     * @param File|null $occupationalAccidentsInsuranceFile
     *
     * @return Enterprise
     */
    public function setOccupationalAccidentsInsuranceFile(File $occupationalAccidentsInsuranceFile = null)
    {
        $this->occupationalAccidentsInsuranceFile = $occupationalAccidentsInsuranceFile;
        if ($occupationalAccidentsInsuranceFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOccupationalAccidentsInsurance()
    {
        return $this->occupationalAccidentsInsurance;
    }

    /**
     * @param string $occupationalAccidentsInsurance
     *
     * @return Enterprise
     */
    public function setOccupationalAccidentsInsurance($occupationalAccidentsInsurance)
    {
        $this->occupationalAccidentsInsurance = $occupationalAccidentsInsurance;

        return $this;
    }

    /**
     * @return File
     */
    public function getOccupationalReceiptFile()
    {
        return $this->occupationalReceiptFile;
    }

    /**
     * @param File|null $occupationalReceiptFile
     *
     * @return Enterprise
     */
    public function setOccupationalReceiptFile(File $occupationalReceiptFile = null)
    {
        $this->occupationalReceiptFile = $occupationalReceiptFile;
        if ($this->occupationalReceiptFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOccupationalReceipt()
    {
        return $this->occupationalReceipt;
    }

    /**
     * @param string $occupationalReceipt
     *
     * @return Enterprise
     */
    public function setOccupationalReceipt($occupationalReceipt)
    {
        $this->occupationalReceipt = $occupationalReceipt;

        return $this;
    }

    /**
     * @return File
     */
    public function getLaborRiskAssessmentFile()
    {
        return $this->laborRiskAssessmentFile;
    }

    /**
     * @param File|null $laborRiskAssessmentFile
     *
     * @return Enterprise
     */
    public function setLaborRiskAssessmentFile(File $laborRiskAssessmentFile = null)
    {
        $this->laborRiskAssessmentFile = $laborRiskAssessmentFile;
        if ($laborRiskAssessmentFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLaborRiskAssessment()
    {
        return $this->laborRiskAssessment;
    }

    /**
     * @param string $laborRiskAssessment
     *
     * @return Enterprise
     */
    public function setLaborRiskAssessment($laborRiskAssessment)
    {
        $this->laborRiskAssessment = $laborRiskAssessment;

        return $this;
    }

    /**
     * @return File
     */
    public function getSecurityPlanFile()
    {
        return $this->securityPlanFile;
    }

    /**
     * @param File|null $securityPlanFile
     *
     * @return Enterprise
     */
    public function setSecurityPlanFile(File $securityPlanFile = null)
    {
        $this->securityPlanFile = $securityPlanFile;
        if ($securityPlanFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSecurityPlan()
    {
        return $this->securityPlan;
    }

    /**
     * @param string $securityPlan
     *
     * @return Enterprise
     */
    public function setSecurityPlan($securityPlan)
    {
        $this->securityPlan = $securityPlan;

        return $this;
    }

    /**
     * @return File
     */
    public function getReaCertificateFile()
    {
        return $this->reaCertificateFile;
    }

    /**
     * @param File|null $reaCertificateFile
     *
     * @return Enterprise
     */
    public function setReaCertificateFile(File $reaCertificateFile = null)
    {
        $this->reaCertificateFile = $reaCertificateFile;
        if ($reaCertificateFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getReaCertificate()
    {
        return $this->reaCertificate;
    }

    /**
     * @param string $reaCertificate
     *
     * @return Enterprise
     */
    public function setReaCertificate($reaCertificate)
    {
        $this->reaCertificate = $reaCertificate;

        return $this;
    }

    /**
     * @return File
     */
    public function getOilCertificateFile()
    {
        return $this->oilCertificateFile;
    }

    /**
     * @param File|null $oilCertificateFile
     *
     * @return Enterprise
     */
    public function setOilCertificateFile(File $oilCertificateFile = null)
    {
        $this->oilCertificateFile = $oilCertificateFile;
        if ($oilCertificateFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getOilCertificate()
    {
        return $this->oilCertificate;
    }

    /**
     * @param string $oilCertificate
     *
     * @return Enterprise
     */
    public function setOilCertificate($oilCertificate)
    {
        $this->oilCertificate = $oilCertificate;

        return $this;
    }

    /**
     * @return File
     */
    public function getGencatPaymentCertificateFile()
    {
        return $this->gencatPaymentCertificateFile;
    }

    /**
     * @param File|null $gencatPaymentCertificateFile
     *
     * @return Enterprise
     */
    public function setGencatPaymentCertificateFile(File $gencatPaymentCertificateFile = null)
    {
        $this->gencatPaymentCertificateFile = $gencatPaymentCertificateFile;
        if ($gencatPaymentCertificateFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getGencatPaymentCertificate()
    {
        return $this->gencatPaymentCertificate;
    }

    /**
     * @param string $gencatPaymentCertificate
     *
     * @return Enterprise
     */
    public function setGencatPaymentCertificate($gencatPaymentCertificate)
    {
        $this->gencatPaymentCertificate = $gencatPaymentCertificate;

        return $this;
    }

    /**
     * @return File
     */
    public function getDeedsOfPowersFile()
    {
        return $this->deedsOfPowersFile;
    }

    /**
     * @param File|null $deedsOfPowersFile
     *
     * @return Enterprise
     */
    public function setDeedsOfPowersFile(File $deedsOfPowersFile = null)
    {
        $this->deedsOfPowersFile = $deedsOfPowersFile;
        if ($deedsOfPowersFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDeedsOfPowers()
    {
        return $this->deedsOfPowers;
    }

    /**
     * @param string $deedsOfPowers
     *
     * @return Enterprise
     */
    public function setDeedsOfPowers($deedsOfPowers)
    {
        $this->deedsOfPowers = $deedsOfPowers;

        return $this;
    }

    /**
     * @return File
     */
    public function getIaeRegistrationFile()
    {
        return $this->iaeRegistrationFile;
    }

    /**
     * @param File|null $iaeRegistrationFile
     *
     * @return Enterprise
     */
    public function setIaeRegistrationFile($iaeRegistrationFile)
    {
        $this->iaeRegistrationFile = $iaeRegistrationFile;
        if ($iaeRegistrationFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getIaeRegistration()
    {
        return $this->iaeRegistration;
    }

    /**
     * @param string $iaeRegistration
     *
     * @return Enterprise
     */
    public function setIaeRegistration($iaeRegistration)
    {
        $this->iaeRegistration = $iaeRegistration;

        return $this;
    }

    /**
     * @return File
     */
    public function getIaeReceiptFile()
    {
        return $this->iaeReceiptFile;
    }

    /**
     * @param File|null $iaeReceiptFile
     *
     * @return Enterprise
     */
    public function setIaeReceiptFile(File $iaeReceiptFile = null)
    {
        $this->iaeReceiptFile = $iaeReceiptFile;
        if ($this->iaeReceiptFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIaeReceipt()
    {
        return $this->iaeReceipt;
    }

    /**
     * @param mixed $iaeReceipt
     *
     * @return Enterprise
     */
    public function setIaeReceipt($iaeReceipt)
    {
        $this->iaeReceipt = $iaeReceipt;

        return $this;
    }

    /**
     * @return File
     */
    public function getMutualPartnershipFile()
    {
        return $this->mutualPartnershipFile;
    }

    /**
     * @param File|null $mutualPartnershipFile
     *
     * @return Enterprise
     */
    public function setMutualPartnershipFile(File $mutualPartnershipFile = null)
    {
        $this->mutualPartnershipFile = $mutualPartnershipFile;
        if ($mutualPartnershipFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getMutualPartnership()
    {
        return $this->mutualPartnership;
    }

    /**
     * @param string $mutualPartnership
     *
     * @return Enterprise
     */
    public function setMutualPartnership($mutualPartnership)
    {
        $this->mutualPartnership = $mutualPartnership;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getTaxIdentificationNumber().' · '.$this->getName() : '---';
    }
}

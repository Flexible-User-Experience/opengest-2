<?php

namespace AppBundle\Command;

use AppBundle\Entity\City;
use AppBundle\Entity\Operator;
use AppBundle\Entity\Province;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportOperatorCommand.
 *
 * @category Command
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ImportOperatorCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:operator');
        $this->setDescription('Import operator from CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
    }

    /**
     * Execute.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     *
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Import CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        while (($row = $this->readRow($fr)) != false) {
            $birthDate = \DateTime::createFromFormat('Y-m-d', $this->readColumn(16, $row));
            $registrationDate = \DateTime::createFromFormat('Y-m-d', $this->readColumn(17, $row));

            $profilePhotoImage = $this->readColumn(8, $row);
            if ($profilePhotoImage != '\\N') {
                $profilePhotoImage = explode('/', $profilePhotoImage);
            }

            $taxIdentityNumberImage = $this->readColumn(18, $row);
            if ($taxIdentityNumberImage != '\\N') {
                $taxIdentityNumberImage = explode('/', $taxIdentityNumberImage);
            }

            $drivingLicenseImg = $this->readColumn(19, $row);
            if ($drivingLicenseImg != '\\N') {
                $drivingLicenseImg = explode('/', $drivingLicenseImg);
            }

            $cranesOperatorLicenseImg = $this->readColumn(20, $row);
            if ($cranesOperatorLicenseImg != '\\N') {
                $drivingLicenseImg = explode('/', $cranesOperatorLicenseImg);
            }

            $medicalCheckImg = $this->readColumn(21, $row);
            if ($medicalCheckImg != '\\N') {
                $medicalCheckImg = explode('/', $medicalCheckImg);
            }

            $episImg = $this->readColumn(41, $row);
            if ($episImg != '\\N') {
                $episImg = explode('/', $episImg);
            }

            $trainingDocImg = $this->readColumn(43, $row);
            if ($trainingDocImg != '\\N') {
                $trainingDocImg = explode('/', $trainingDocImg);
            }

            $informationImg = $this->readColumn(44, $row);
            if ($informationImg != '\\N') {
                $informationImg = explode('/', $informationImg);
            }

            $useOfMachineryAuthorizationImg = $this->readColumn(45, $row);
            if ($useOfMachineryAuthorizationImg != '\\N') {
                $useOfMachineryAuthorizationImg = explode('/', $useOfMachineryAuthorizationImg);
            }

            $dischargeSocialSecurityImg = $this->readColumn(46, $row);
            if ($dischargeSocialSecurityImg != '\\N') {
                $dischargeSocialSecurityImg = explode('/', $dischargeSocialSecurityImg);
            }

            $employmentContractImg = $this->readColumn(47, $row);
            if ($employmentContractImg != '\\N') {
                $employmentContractImg = explode('/', $employmentContractImg);
            }

            $enterprise = $this->em->getRepository('AppBundle:Enterprise')->findOneBy(['taxIdentificationNumber' => $this->readColumn(54, $row)]);
            if ($enterprise && $birthDate && $registrationDate) {
                $province = $this->em->getRepository('AppBundle:Province')->findOneBy(['name' => $this->readColumn(12, $row)]);
                if (!$province) {
                    // new record
                    $province = new Province();
                }
                $province
                    ->setName($this->readColumn(12, $row))
                    ->setCode(strtoupper(substr($this->readColumn(12, $row), 0, 1)))
                    ->setCountry('ES')
                ;
                $this->em->persist($province);

                $city = $this->em->getRepository('AppBundle:City')->findOneBy(['postalCode' => $this->readColumn(10, $row)]);
                if (!$city) {
                    // new record
                    $city = new City();
                }
                $city
                    ->setName($this->readColumn(11, $row))
                    ->setProvince($province)
                    ->setPostalCode($this->readColumn(10, $row))
                ;
                $this->em->persist($city);

                $operator = $this->em->getRepository('AppBundle:Operator')->findOneBy(['taxIdentificationNumber' => $this->readColumn(4, $row)]);
                if (!$operator) {
                    // new record
                    $operator = new Operator();
                    ++$newRecords;
                }
                $operator
                    ->setEnterprise($enterprise)
                    ->setEnabled($this->readColumn(3, $row))
                    ->setTaxIdentificationNumber($this->readColumn(4, $row))
                    ->setName($this->readColumn(5, $row))
                    ->setSurname1($this->readColumn(6, $row))
                    ->setSurname2($this->readColumn(7, $row))
                    ->setProfilePhotoImage(is_array($profilePhotoImage) ? $profilePhotoImage[1] : null)
                    ->setAddress($this->readColumn(9, $row))
                    ->setCity($city)
                    ->setOwnPhone($this->readColumn(13, $row))
                    ->setOwnMobile($this->readColumn(14, $row))
                    ->setEnterpriseMobile($this->readColumn(15, $row))
                    ->setBrithDate($birthDate)
                    ->setRegistrationDate($registrationDate)
                    ->setTaxIdentificationNumberImage(is_array($taxIdentityNumberImage) ? $taxIdentityNumberImage[1] : null)
                    ->setDrivingLicenseImage(is_array($drivingLicenseImg) ? $drivingLicenseImg[1] : null)
                    ->setCranesOperatorLicenseImage(is_array($cranesOperatorLicenseImg) ? $cranesOperatorLicenseImg[1] : null)
                    ->setMedicalCheckImage(is_array($medicalCheckImg) ? $medicalCheckImg[1] : null)
                    ->setHasCarDrivingLicense($this->readColumn(22, $row))
                    ->setHasLorryDrivingLicense($this->readColumn(23, $row))
                    ->setHasCraneDrivingLicense($this->readColumn(24, $row))
                    ->setHasTowingDrivingLicense($this->readColumn(25, $row))
                    ->setShoeSize($this->readColumn(26, $row))
                    ->setJerseytSize($this->readColumn(27, $row))
                    ->setJacketSize($this->readColumn(28, $row))
                    ->setTShirtSize($this->readColumn(29, $row))
                    ->setPantSize($this->readColumn(30, $row))
                    ->setWorkingDressSize($this->readColumn(31, $row))
                    ->setBancAccountNumber(($this->readColumn(52, $row) != '\\N' ? $this->readColumn(52, $row).'-' : '').$this->readColumn(33, $row).'-'.$this->readColumn(34, $row).'-'.$this->readColumn(35, $row).'-'.$this->readColumn(36, $row))
                    ->setSocialSecurityNumber($this->readColumn(37, $row))
                    ->setEpisImage(is_array($episImg) ? $episImg[1] : null)
                    ->setTrainingDocumentImage(is_array($trainingDocImg) ? $trainingDocImg[1] : null)
                    ->setInformationImage(is_array($informationImg) ? $trainingDocImg[1] : null)
                    ->setUseOfMachineryAuthorizationImage(is_array($useOfMachineryAuthorizationImg) ? $useOfMachineryAuthorizationImg[1] : null)
                    ->setDischargeSocialSecurityImage(is_array($dischargeSocialSecurityImg) ? $dischargeSocialSecurityImg[1] : null)
                    ->setEmploymentContractImage(is_array($employmentContractImg) ? $employmentContractImg[1] : null)
                ;

                if ($this->readColumn(38, $row) != '\\N') {
                    $operator->setHourCost($this->readColumn(38, $row));
                }

                $this->em->persist($operator);

                $output->writeln($this->readColumn(4, $row).' · '.$this->readColumn(5, $row).' · '.$this->readColumn(52, $row).'-'.$this->readColumn(33, $row).'-'.$this->readColumn(34, $row).'-'.$this->readColumn(35, $row).'-'.$this->readColumn(36, $row).' · '.$this->readColumn(16, $row).' · '.$this->readColumn(17, $row));
            } else {
                ++$errors;
                $output->writeln('<error>Error a la fila: '.$rowsRead.'</error>');
            }

            ++$rowsRead;
            $this->em->flush();
        }

        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors);
    }
}

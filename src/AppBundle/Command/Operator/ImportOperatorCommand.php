<?php

namespace AppBundle\Command\Operator;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Operator\Operator;
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
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Import CSV rows
        $beginTimestamp = new \DateTime();
        $notFoundDate = \DateTime::createFromFormat('Y-m-d H:i:s', '2000-01-01 00:00:00');
        $rowsRead = 1;
        $newRecords = 0;
        $errors = 0;
        while (false != ($row = $this->readRow($fr))) {
            $birthDate = \DateTime::createFromFormat('Y-m-d', $this->readColumn(16, $row));
            $registrationDate = \DateTime::createFromFormat('Y-m-d', $this->readColumn(17, $row));

            $profilePhotoImage = $this->readColumn(8, $row);
            if (!is_null($profilePhotoImage)) {
                $profilePhotoImage = explode('/', $profilePhotoImage);
            }

            $taxIdentityNumberImage = $this->readColumn(18, $row);
            if (!is_null($taxIdentityNumberImage)) {
                $taxIdentityNumberImage = explode('/', $taxIdentityNumberImage);
            }

            $drivingLicenseImg = $this->readColumn(19, $row);
            if (!is_null($drivingLicenseImg)) {
                $drivingLicenseImg = explode('/', $drivingLicenseImg);
            }

            $cranesOperatorLicenseImg = $this->readColumn(20, $row);
            if (!is_null($cranesOperatorLicenseImg)) {
                $drivingLicenseImg = explode('/', $cranesOperatorLicenseImg);
            }

            $medicalCheckImg = $this->readColumn(21, $row);
            if (!is_null($medicalCheckImg)) {
                $medicalCheckImg = explode('/', $medicalCheckImg);
            }

            $episImg = $this->readColumn(41, $row);
            if (!is_null($episImg)) {
                $episImg = explode('/', $episImg);
            }

            $trainingDocImg = $this->readColumn(43, $row);
            if (!is_null($trainingDocImg)) {
                $trainingDocImg = explode('/', $trainingDocImg);
            }

            $informationImg = $this->readColumn(44, $row);
            if (!is_null($informationImg)) {
                $informationImg = explode('/', $informationImg);
            }

            $useOfMachineryAuthorizationImg = $this->readColumn(45, $row);
            if (!is_null($useOfMachineryAuthorizationImg)) {
                $useOfMachineryAuthorizationImg = explode('/', $useOfMachineryAuthorizationImg);
            }

            $dischargeSocialSecurityImg = $this->readColumn(46, $row);
            if (!is_null($dischargeSocialSecurityImg)) {
                $dischargeSocialSecurityImg = explode('/', $dischargeSocialSecurityImg);
            }

            $employmentContractImg = $this->readColumn(47, $row);
            if (!is_null($employmentContractImg)) {
                $employmentContractImg = explode('/', $employmentContractImg);
            }

            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $this->readColumn(54, $row)]);
            $province = $this->em->getRepository('AppBundle:Setting\Province')->findOneBy(['name' => $this->readColumn(12, $row)]);
            $city = $this->em->getRepository('AppBundle:Setting\City')->findOneBy(['postalCode' => $this->readColumn(10, $row)]);

            if ($enterprise && $birthDate && $registrationDate && $province && $city) {
                $operator = $this->em->getRepository('AppBundle:Operator\Operator')->findOneBy(['taxIdentificationNumber' => $this->readColumn(4, $row)]);
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
                    ->setBancAccountNumber(!is_null(($this->readColumn(52, $row)) ? $this->readColumn(52, $row).'-' : '').$this->readColumn(33, $row).'-'.$this->readColumn(34, $row).'-'.$this->readColumn(35, $row).'-'.$this->readColumn(36, $row))
                    ->setSocialSecurityNumber($this->readColumn(37, $row))
                    ->setEpisImage(is_array($episImg) ? $episImg[1] : null)
                    ->setTrainingDocumentImage(is_array($trainingDocImg) ? $trainingDocImg[1] : null)
                    ->setInformationImage(is_array($informationImg) ? $trainingDocImg[1] : null)
                    ->setUseOfMachineryAuthorizationImage(is_array($useOfMachineryAuthorizationImg) ? $useOfMachineryAuthorizationImg[1] : null)
                    ->setDischargeSocialSecurityImage(is_array($dischargeSocialSecurityImg) ? $dischargeSocialSecurityImg[1] : null)
                    ->setEmploymentContractImage(is_array($employmentContractImg) ? $employmentContractImg[1] : null)
                ;

                if (!is_null($this->readColumn(38, $row))) {
                    $operator->setHourCost($this->readColumn(38, $row));
                }

                $this->em->persist($operator);

                $output->writeln('#'.$rowsRead.' · '.$this->readColumn(4, $row).' · '.$this->readColumn(5, $row).' '.$this->readColumn(6, $row).' · '.$this->readColumn(52, $row).'-'.$this->readColumn(33, $row).'-'.$this->readColumn(34, $row).'-'.$this->readColumn(35, $row).'-'.$this->readColumn(36, $row).' · '.$this->readColumn(16, $row).' · '.$this->readColumn(17, $row));
            } else {
                ++$errors;
                $output->write('<error>#'.$rowsRead.' · '.$this->readColumn(4, $row).' · '.$this->readColumn(5, $row).' '.$this->readColumn(6, $row));
                if (!$enterprise) {
                    $output->write(' · no enterprise found');
                }
                if (!$birthDate) {
                    $output->write(' · no birth date found');
                }
                if (!$registrationDate) {
                    $output->write(' · no registration date found');
                }
                if (!$province) {
                    $output->write(' · no province found');
                }
                if (!$city) {
                    $output->write(' · no city found');
                }
                $output->writeln('</error>');
            }

            ++$rowsRead;
            $this->em->flush();
        }

        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead - 1, $newRecords, $beginTimestamp, $endTimestamp, $errors);
    }
}

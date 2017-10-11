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

                $city = $this->em->getRepository('AppBundle:City')->findOneBy(['postalCode' => $this->readColumn(7, $row)]);
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
                    ->setAddress($this->readColumn(9, $row))
                    ->setCity($city)
                    ->setOwnPhone($this->readColumn(13, $row))
                    ->setOwnMobile($this->readColumn(14, $row))
                    ->setEnterpriseMobile($this->readColumn(15, $row))
                    ->setBrithDate($birthDate)
                    ->setRegistrationDate($registrationDate)
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

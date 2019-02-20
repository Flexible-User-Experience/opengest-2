<?php

namespace AppBundle\Command\Enterprise;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Setting\Province;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportEnterpriseCsvCommand.
 *
 * @category Command
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ImportEnterpriseCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:enterprise');
        $this->setDescription('Import enterprise from CSV file');
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

        // Set counters
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;

        // Import CSV rows
        while (false != ($row = $this->readRow($fr))) {
            $output->writeln($this->readColumn(8, $row).' · '.$this->readColumn(2, $row));

//            $province = $this->em->getRepository('AppBundle:Setting\Province')->findOneBy(['name' => $this->readColumn(5, $row)]);
//            if (!$province) {
//                // new record
//                $province = new Province();
//            }
//            $province
//                ->setName($this->readColumn(5, $row))
//                ->setCode(strtoupper(substr($this->readColumn(5, $row), 0, 1)))
//                ->setCountry('ES')
//            ;
//            $this->em->persist($province);
            $cityName = $this->readColumn(4, $row);
            $postalCode = $this->readColumn(7, $row);
            if (strlen($cityName) > 0) {
                $cityName = $this->lts->cityNameCleaner($cityName);
            } else {
                $cityName = '---';
            }
            if (0 == strlen($postalCode)) {
                $postalCode = '---';
            }
            $city = $this->em->getRepository('AppBundle:Setting\City')->findOneBy([
                'postalCode' => $this->readColumn(7, $row),
            ]);
            if ($city) {
                $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $this->readColumn(8, $row)]);
                if (!$enterprise) {
                    // new record
                    $enterprise = new Enterprise();
                    ++$newRecords;
                }
                $enterprise
                    ->setTaxIdentificationNumber($this->readColumn(8, $row))
                    ->setBusinessName($this->readColumn(2, $row))
                    ->setName($this->readColumn(1, $row))
                    ->setAddress($this->readColumn(3, $row))
                    ->setCity($city)
                    ->setPhone1($this->readColumn(9, $row))
                    ->setPhone2($this->readColumn(10, $row))
                    ->setPhone3($this->readColumn(11, $row))
                    ->setFax($this->readColumn(12, $row))
                    ->setEmail($this->readColumn(13, $row))
                    ->setWww($this->readColumn(14, $row))
                    ->setEnabled($this->readColumn(15, $row))
                    ->setLogo($this->readColumn(16, $row))
                    ->setDeedOfIncorporation($this->readColumn(17, $row))
                    ->setTaxIdentificationNumberCard($this->readColumn(18, $row))
                    ->setTc1Receipt($this->readColumn(19, $row))
                    ->setTc2Receipt($this->readColumn(20, $row))
                    ->setSsPaymentCertificate($this->readColumn(21, $row))
                    ->setRc1Insurance($this->readColumn(22, $row))
                    ->setRc2Insurance($this->readColumn(23, $row))
                    ->setRcReceipt($this->readColumn(24, $row))
                    ->setPreventionServiceContract($this->readColumn(25, $row))
                    ->setPreventionServiceInvoice($this->readColumn(26, $row))
                    ->setPreventionServiceReceipt($this->readColumn(27, $row))
                    ->setOccupationalAccidentsInsurance($this->readColumn(28, $row))
                    ->setOccupationalReceipt($this->readColumn(29, $row))
                    ->setLaborRiskAssessment($this->readColumn(30, $row))
                    ->setSecurityPlan($this->readColumn(31, $row))
                    ->setReaCertificate($this->readColumn(32, $row))
                    ->setOilCertificate($this->readColumn(33, $row))
                    ->setGencatPaymentCertificate($this->readColumn(34, $row))
                    ->setDeedsOfPowers($this->readColumn(35, $row))
                    ->setSsRegistration($this->readColumn(36, $row))
                    ->setIaeRegistration($this->readColumn(37, $row))
                    ->setIaeReceipt($this->readColumn(38, $row))
                    ->setMutualPartnership($this->readColumn(39, $row))
                ;
                $this->em->persist($enterprise);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW) {
                    $this->em->flush();
                }
            } else {
                $output->writeln('<error>Error a la fila: '.$rowsRead.'</error>');
                ++$errors;
            }
//            $city
//                ->setName($this->readColumn(4, $row))
//                ->setProvince($province)
//                ->setPostalCode($this->readColumn(7, $row))
//            ;
//            $this->em->persist($city);

            ++$rowsRead;
        }
        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors);
    }
}

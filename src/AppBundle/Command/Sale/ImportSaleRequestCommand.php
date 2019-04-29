<?php

namespace AppBundle\Command\Sale;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Sale\SaleInvoice;
use AppBundle\Entity\Sale\SaleRequest;
use DateTime;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportSaleRequestCommand.
 *
 * @category Command
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class ImportSaleRequestCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:sale:request');
        $this->setDescription('Import sale invoice from CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addOption('dry-run', null, InputOption::VALUE_NONE, 'don\'t persist changes into database');
    }

    /**
     * Execute.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
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
        $beginTimestamp = new DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;
        $errorMessagesArray = array();

        // Import CSV rows
        while (false != ($row = $this->readRow($fr))) {
            $saleDeliveryNoteId = $this->readColumn(1, $row);
            $invoiceToId = $this->readColumn(2, $row);
            $tariffId = $this->readColumn(3, $row);
            $partnerId = $this->readColumn(4, $row);
            $operatorId = $this->readColumn(5, $row);
            $vehicleId = $this->readColumn(6, $row);
            $enterpriseId = $this->readColumn(7, $row);
            $contactPersonName = $this->readColumn(8, $row);
            $contactPersonPhone = $this->readColumn(9, $row);
            $serviceDescription = $this->readColumn(10, $row);
            $height = $this->readColumn(11, $row);
            $distance = $this->readColumn(12, $row);
            $weight = $this->readColumn(13, $row);
            $utensils = $this->readColumn(14, $row);
            $place = $this->readColumn(15, $row);
            $requestDate = DateTime::createFromFormat('Y-m-d', $this->readColumn(16, $row));
            $requestTime = DateTime::createFromFormat('H:i', '0:0');
            $serviceDate = DateTime::createFromFormat('Y-m-d', $this->readColumn(17, $row));
            $serviceTime = DateTime::createFromFormat('H:i', $this->readColumn(18, $row));
            $attededById = $this->readColumn(19, $row);
            $miniumHours = $this->readColumn(20, $row);
            $displacement = $this->readColumn(21, $row);
            $hourPrice = $this->readColumn(22, $row);
            $hasBeenPrinted = $this->readColumn(23, $row);
            $secondaryVehicleId = $this->readColumn(24, $row);
            $endServiceTime = DateTime::createFromFormat('H:i', $this->readColumn(25, $row));
            $deliveryNoteNumber = $this->readColumn(26, $row);
            $invoiceToTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(27, $row));
            $tariffTonage = $this->readColumn(28, $row);
            $partnerTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(29, $row));
            $operatorTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(30, $row));
            $vehicleRegistratorNumber = $this->readColumn(31, $row);
            $enterpriseTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(32, $row));
            $secondaryVehicleRegistrationNumber = $this->readColumn(33, $row);
            $attendedByName = $this->readColumn(34, $row);
            $deliveryNote = $this->em->getRepository('AppBundle:Sale\SaleDeliveryNote')->findOneBy(['deliveryNoteNumber' => $deliveryNoteNumber]);
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $enterpriseTaxIdentificationNumber]);
            $invoiceTo = $this->em->getRepository('AppBundle:Partner\Partner')->findOneBy([
                'cifNif' => $invoiceToTaxIdentificationNumber,
                'enterprise' => $enterprise,
            ]);
            $tariff = $this->em->getRepository('AppBundle:Sale\SaleTariff')->findOneBy([$tariffTonage]);
            $partner = $this->em->getRepository('AppBundle:Partner\Partner')->findOneBy([
                'cifNif' => $partnerTaxIdentificationNumber,
                'enterprise' => $enterprise,
            ]);
            $operator = $this->em->getRepository('AppBundle:Operator\Operator')->findOneBy(['taxIdentificationNumber' => $operatorTaxIdentificationNumber]);
            $vehicle = $this->em->getRepository('AppBundle:Vehicle\Vehicle')->findOneBy(['vehicleRegistrationNumber' => $vehicleRegistratorNumber]);
            $secondaryVehicle = $this->em->getRepository('AppBundle:Vehicle\Vehicle')->findOneBy(['vehicleRegistrationNumber' => $secondaryVehicleRegistrationNumber]);
            //$attendedBy = $this->em->getRepository('FOSUserBundle:UserManager')->findOneBy(['name' => $attendedByName]);

            $printLineMessage = '#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$serviceDescription.' · '.$requestDate.' · '.$requestTime.' · '.$serviceDate.' · '.$serviceTime.' · '.$hasBeenPrinted;
            $output->writeln($printLineMessage);

            if ($serviceDescription && $requestDate && $requestTime && $serviceDate && $serviceTime && $hasBeenPrinted) {
                $saleRequest = $this->em->getRepository('AppBundle:Sale\SaleRequest')->findOneBy([
                    'serviceDescription' => $serviceDescription,
                    'requestDate' => $requestDate,
                    'serviceDate' => $serviceDate,
                    'hasBeenPrinted' => $hasBeenPrinted,
                ]);
                if (!$saleRequest) {
                    // new record
                    $saleRequest = new SaleRequest();
                    ++$newRecords;
                }
                /* @var SaleInvoice $saleInvoice */
                $saleRequest
                    ->setEnterprise($enterprise)
                    ->setPartner($partner)
                    ->setInvoiceTo($invoiceTo)
                    ->setVehicle($vehicle)
                    ->setOperator($operator)
                    ->setTariff($tariff)
                    ->setSaleDeliveryNote($deliveryNote)
                    //->setAttendedBy($atendedBy)
                    ->setSecondaryVehicle($secondaryVehicle)
                    ->setServiceDescription($serviceDescription)
                    ->setHeight($height)
                    ->setDistance($distance)
                    ->setWeight($weight)
                    ->setPlace($place)
                    ->setUtensils($utensils)
                    ->setObservations('')
                    ->setRequestDate($requestDate)
                    ->setRequestTime($requestTime)
                    ->setServiceDate($serviceDate)
                    ->setServiceTime($serviceTime)
                    ->setHourPrice($hourPrice)
                    ->setMiniumHours($miniumHours)
                    ->setDisplacement($displacement)
                    ->setContactPersonName($contactPersonName)
                    ->setContactPersonPhone($contactPersonPhone)
                    ->setEndServiceTime($endServiceTime)
                    ->setHasBeenPrinted(1 == $hasBeenPrinted ? true : false)

                ;
                $this->em->persist($saleRequest);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
            } else {
                $output->write('<error>Error at row number #'.$rowsRead);
                if (!$serviceDescription) {
                    $output->write(' · no service description found');
                    $errorMessagesArray[] = $printLineMessage.' · no service description found';
                }
                if (!$requestDate) {
                    $output->write(' · no request date found');
                    $errorMessagesArray[] = $printLineMessage.' · no request date found';
                }
                if (!$requestTime) {
                    $output->write(' · no request time found');
                    $errorMessagesArray[] = $printLineMessage.' · no request time found';
                }
                if (!$serviceDate) {
                    $output->write(' · no service date found');
                    $errorMessagesArray[] = $printLineMessage.' · no service date found';
                }
                if (!$serviceTime) {
                    $output->write(' · no service time found');
                    $errorMessagesArray[] = $printLineMessage.' · no service time found';
                }
                if (!$hasBeenPrinted) {
                    $output->write(' · no has been printed register found');
                    $errorMessagesArray[] = $printLineMessage.' · no has been printed register found';
                }
                $output->writeln('</error>');
                ++$errors;
            }
            ++$rowsRead;
        }
        if (!$input->getOption('dry-run')) {
            $this->em->flush();
        }

        // Print totals
        $endTimestamp = new DateTime();
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors, $input->getOption('dry-run'));
        if (count($errorMessagesArray) > 0) {
            /** @var string $errorMessage */
            foreach ($errorMessagesArray as $errorMessage) {
                $output->writeln($errorMessage);
            }
        }
    }
}

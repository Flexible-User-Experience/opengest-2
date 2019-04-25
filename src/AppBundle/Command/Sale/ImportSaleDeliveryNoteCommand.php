<?php

namespace AppBundle\Command\Sale;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Sale\SaleInvoice;
use DateTime;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportSaleTariffCommand.
 *
 * @category Command
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class ImportSaleDeliveryNoteCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:sale:delivery:note');
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
            $invoiceNumber = $this->readColumn(2, $row);
            $date = DateTime::createFromFormat('Y-m-d', $this->readColumn(3, $row));
            $hasBeenCounted = $this->readColumn(4, $row);
            $type = $this->readColumn(5, $row);
            $total = $this->readColumn(6, $row);
            $seriesName = $this->readColumn(8, $row);
            $partnerTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(9, $row));
            $enterpriseTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(10, $row));
            $series = $this->em->getRepository('AppBundle:Setting\SaleInvoiceSeries')->findOneBy(['name' => $seriesName]);
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $enterpriseTaxIdentificationNumber]);
            $partner = $this->em->getRepository('AppBundle:Partner\Partner')->findOneBy([
                'cifNif' => $partnerTaxIdentificationNumber,
                'enterprise' => $enterprise,
            ]);
            $printLineMessage = '#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$invoiceNumber.' · '.$date->format('d/m/Y').' · '.$hasBeenCounted.' · '.$type.' · '.$total.' · '.$seriesName.' · '.$partnerTaxIdentificationNumber.' · '.$enterpriseTaxIdentificationNumber;
            $output->writeln($printLineMessage);

            if ($date && $invoiceNumber && $type && $series && $partner) {
                $saleInvoice = $this->em->getRepository('AppBundle:Sale\SaleInvoice')->findOneBy([
                    'date' => $date,
                    'invoiceNumber' => $invoiceNumber,
                    'type' => $type,
                ]);
                if (!$saleInvoice) {
                    // new record
                    $saleInvoice = new SaleInvoice();
                    ++$newRecords;
                }
                /* @var SaleInvoice $saleInvoice */
                $saleInvoice
                    ->setPartner($partner)
                    ->setSeries($series)
                    ->setInvoiceNumber(intval($invoiceNumber))
                    ->setDate($date)
                    ->setHasBeenCounted(1 == $hasBeenCounted ? true : false)
                    ->setType($type)
                    ->setTotal($total)
                ;
                $this->em->persist($saleInvoice);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
            } else {
                $output->write('<error>Error at row number #'.$rowsRead);
                if (!$date) {
                    $output->write(' · no date found');
                    $errorMessagesArray[] = $printLineMessage.' · no date found';
                }
                if (!$invoiceNumber) {
                    $output->write(' · no invoice number found');
                    $errorMessagesArray[] = $printLineMessage.' · no invoice number found';
                }
                if (!$type) {
                    $output->write(' · no type found');
                    $errorMessagesArray[] = $printLineMessage.' · no type found';
                }
                if (!$series) {
                    $output->write(' · no invoice serie found');
                    $errorMessagesArray[] = $printLineMessage.' · no invoice serie found';
                }
                if (!$partner) {
                    $output->write(' · no partner found');
                    $errorMessagesArray[] = $printLineMessage.' · no partner found';
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

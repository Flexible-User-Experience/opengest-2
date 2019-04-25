<?php

namespace AppBundle\Command\Sale;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Sale\SaleDeliveryNote;
use DateTime;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportSaleDeliveryNoteCommand.
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
        $this->setDescription('Import sale delivery note from CSV file');
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
            $partnerId = $this->readColumn(1, $row);
            $partnerBuildingSiteId = $this->readColumn(2, $row);
            $partnerOrderId = $this->readColumn(3, $row);
            $deliveryNoteNumber = $this->readColumn(5, $row);
            $discount = $this->readColumn(6, $row);
            $date = DateTime::createFromFormat('Y-m-d', $this->readColumn(7, $row));
            $collectionDocumentTypeId = $this->readColumn(8, $row);
            $collectionTerm = $this->readColumn(9, $row);
            $activityLineId = $this->readColumn(10, $row);
            $wontBeInvoiced = $this->readColumn(11, $row);
            $activityLineName = $this->readColumn(12, $row);
            $collectionDocumentTypeName = $this->readColumn(13, $row);
            $partnerOrderNumber = $this->readColumn(14, $row);
            $partnerTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(15, $row));
            $enterpriseTaxIdentificationNumber = $this->lts->taxIdentificationNumberCleaner($this->readColumn(16, $row));
            $partnerBuildingSiteName = $this->readColumn(17, $row);
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $enterpriseTaxIdentificationNumber]);
            $partner = $this->em->getRepository('AppBundle:Partner\Partner')->findOneBy([
                'cifNif' => $partnerTaxIdentificationNumber,
                'enterprise' => $enterprise,
            ]);
            $partnerBuildingSite = $this->em->getRepository('AppBundle:Partner\PartnerBuildingSite')->findOneBy([
                'id' => $partnerBuildingSiteId,
                'name' => $partnerBuildingSiteName,
            ]);
            $partnerOrder = $this->em->getRepository('AppBundle:Partner\PartnerOrder')->findOneBy([
                'id' => $partnerOrderId,
                'number' => $partnerOrderNumber,
            ]);
            $collectionDocumentType = $this->em->getRepository('AppBundle:Enterprise\CollectionDocumentType')->findOneBy([
                'id' => $collectionDocumentTypeId,
                'name' => $collectionDocumentTypeName,
            ]);
            $activityLine = $this->em->getRepository('AppBundle:Enterprise\ActivityLine')->findOneBy([
                'id' => $activityLineId,
                'name' => $activityLineName,
            ]);

            $printLineMessage = '#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$partnerId.' · '.$partnerBuildingSiteId.' · '.$partnerOrderId.' · '.$deliveryNoteNumber.' · '.$discount.' · '.$date->format('d/m/Y').' · '.$collectionDocumentTypeId.' · '.$collectionTerm.' · '.$activityLineId.' · '.$wontBeInvoiced.' · '.$partnerTaxIdentificationNumber.' · '.$enterpriseTaxIdentificationNumber;
            $output->writeln($printLineMessage);

            if ($date && $deliveryNoteNumber) {
                $saleDeliveryNote = $this->em->getRepository('AppBundle:Sale\SaleDeliveryNote')->findOneBy([
                    'date' => $date,
                    'deliveryNoteNumber' => $deliveryNoteNumber,
                ]);
                if (!$saleDeliveryNote) {
                    // new record
                    $saleDeliveryNote = new SaleDeliveryNote();
                    ++$newRecords;
                }
                /* @var SaleDeliveryNote $saleDeliveryNote */
                $saleDeliveryNote
                    ->setEnterprise($enterprise)
                    ->setPartner($partner)
                    ->setBuildingSite($partnerBuildingSite)
                    ->setOrder($partnerOrder)
                    ->setCollectionDocument($collectionDocumentType)
                    ->setActivityLine($activityLine)
                    ->setDate($date)
                    ->setDeliveryNoteNumber($deliveryNoteNumber)
                    ->setBaseAmount(0)
                    ->setDiscount($discount)
                    ->setCollectionTerm($collectionTerm)
                    ->setWontBeInvoiced($wontBeInvoiced)
                ;
                $this->em->persist($saleDeliveryNote);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
            } else {
                $output->write('<error>Error at row number #'.$rowsRead);
                if (!$date) {
                    $output->write(' · no date found');
                    $errorMessagesArray[] = $printLineMessage.' · no date found';
                }
                if (!$deliveryNoteNumber) {
                    $output->write(' · no delivery note number found');
                    $errorMessagesArray[] = $printLineMessage.' · no delivery note number found';
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

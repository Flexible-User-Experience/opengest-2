<?php

namespace AppBundle\Command\Sale;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Sale\SaleInvoice;
use AppBundle\Entity\Sale\SaleRequestHasDeliveryNote;
use DateTime;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportSaleRequestHasDeliveryNoteCommand.
 *
 * @category Command
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class ImportSaleRequestHasDeliveryNoteCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:sale:request:has:delivery:note');
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
            $deliveryNoteId = $this->readColumn(0, $row);
            $saleRequestId = $this->readColumn(1, $row);
            $reference = $this->readColumn(2, $row);
            $totalHoursMorning = $this->readColumn(3, $row);
            $priceHoursMorning = $this->readColumn(4, $row);
            $amountMorning = $this->readColumn(5, $row);
            $totalHoursAfternoon = $this->readColumn(6, $row);
            $priceHoursAfternoon = $this->readColumn(7, $row);
            $amountAfternoon = $this->readColumn(8, $row);
            $totalHoursNight = $this->readColumn(9, $row);
            $priceHoursNight = $this->readColumn(10, $row);
            $amountNight = $this->readColumn(11, $row);
            $totalHoursEarlyMorning = $this->readColumn(12, $row);
            $priceHoursEarlyMorning = $this->readColumn(13, $row);
            $amountEarlyMorning = $this->readColumn(14, $row);
            $totalHoursDisplacement = $this->readColumn(15, $row);
            $priceHoursDisplacement = $this->readColumn(16, $row);
            $amountDisplacement = $this->readColumn(17, $row);
            $ivaType = $this->readColumn(18, $row);
            $retentionType = $this->readColumn(19, $row);
            $deliveryNote = $this->em->getRepository('AppBundle:Sale\SaleDeliveryNote')->findOneBy([
               'deliveryNoteNumber' => $this->readColumn(20, $row),
            ]);
            $saleRequest = $this->em->getRepository('AppBundle:Sale\SaleRequest')->findOneBy([
                'requestDate' => $this->readColumn(21, $row),
                'serviceDate' => $this->readColumn(22, $row),
                'serviceDescription' => $this->readColumn(23, $row),
            ]);

            $printLineMessage = '#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$saleRequestId.' · '.$reference.' · '.$ivaType.' · '.$retentionType;
            $output->writeln($printLineMessage);

            if ($saleRequest && $deliveryNote) {
                $saleRequestHasDeliveryNote = $this->em->getRepository('AppBundle:Sale\SaleRequestHasDeliveryNote')->findOneBy([
                    'saleRequest' => $saleRequest,
                    'saleDeliveryNote' => $deliveryNote,
                ]);
                if (!$saleRequestHasDeliveryNote) {
                    // new record
                    $saleRequestHasDeliveryNote = new SaleRequestHasDeliveryNote();
                    ++$newRecords;
                }
                /* @var SaleInvoice $saleInvoice */
                $saleRequestHasDeliveryNote
                    ->setSaleRequest($saleRequest)
                    ->setSaleDeliveryNote($deliveryNote)
                    ->setReference($reference)
                    ->setTotalHoursMorning($totalHoursMorning)
                    ->setPriceHourMorning($priceHoursMorning)
                    ->setAmountMorning($amountMorning)
                    ->setTotalHoursAfternoon($totalHoursAfternoon)
                    ->setPriceHourAfternoon($priceHoursAfternoon)
                    ->setAmountAfternoon($amountAfternoon)
                    ->setTotalHoursNight($totalHoursNight)
                    ->setPriceHourNight($priceHoursNight)
                    ->setAmountNight($amountNight)
                    ->setTotalHoursEarlyMorning($totalHoursEarlyMorning)
                    ->setPriceHourEarlyMorning($priceHoursEarlyMorning)
                    ->setAmountEarlyMorning($amountEarlyMorning)
                    ->setTotalHoursDisplacement($totalHoursDisplacement)
                    ->setPriceHourDisplacement($priceHoursDisplacement)
                    ->setAmountDisplacement($amountDisplacement)
                    ->setIvaType($ivaType)
                    ->setRetentionType($retentionType)
                ;
                $this->em->persist($saleRequestHasDeliveryNote);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
            } else {
                $output->write('<error>Error at row number #'.$rowsRead);
                if (!$saleRequest) {
                    $output->write(' · no sale request found');
                    $errorMessagesArray[] = $printLineMessage.' · no sale request found';
                }
                if (!$deliveryNote) {
                    $output->write(' · no sale delivery note found');
                    $errorMessagesArray[] = $printLineMessage.' · no sale delivery note found';
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

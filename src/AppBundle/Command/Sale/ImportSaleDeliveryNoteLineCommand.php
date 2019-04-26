<?php

namespace AppBundle\Command\Sale;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Sale\SaleDeliveryNote;
use AppBundle\Entity\Sale\SaleDeliveryNoteLine;
use DateTime;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportSaleDeliveryNoteLineCommand.
 *
 * @category Command
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class ImportSaleDeliveryNoteLineCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:sale:delivery:note:line');
        $this->setDescription('Import sale delivery note line from CSV file');
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
            $deliveryNoteId = $this->readColumn(1, $row);
            $description = $this->readColumn(2, $row);
            $units = $this->readColumn(3, $row);
            $priceUnit = $this->readColumn(4, $row);
            $iva = $this->readColumn(5, $row);
            $irpf = $this->readColumn(6, $row);
            $discount = $this->readColumn(7, $row);
            $deliveryNoteNumber = $this->readColumn(8, $row);
            $saleDeliveryNote = $this->em->getRepository('AppBundle:Sale\SaleDeliveryNote')->findOneBy([
               'id' => $deliveryNoteId,
               'deliveryNoteNumber' => $deliveryNoteNumber,
            ]);

            $printLineMessage = '#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$deliveryNoteId.' · '.$description.' · '.$units.' · '.$priceUnit.' · '.$iva.' · '.$irpf.' · '.$discount.' · '.$deliveryNoteNumber;
            $output->writeln($printLineMessage);

            if ($priceUnit && $iva && $irpf) {
                $saleDeliveryNoteLine = $this->em->getRepository('AppBundle:Sale\SaleDeliveryNoteLine')->findOneBy([
                    'priceUnit' => $priceUnit,
                    'iva' => $iva,
                    'irpf' => $irpf,
                ]);
                if (!$saleDeliveryNoteLine) {
                    // new record
                    $saleDeliveryNote = new SaleDeliveryNote();
                    ++$newRecords;
                }

                $base = $units * $priceUnit - ($discount * $priceUnit * $units / 100);
                $ivaAmount = $base * ($iva / 100);
                $irpfAmount = $base * ($irpf / 100);
                $total = $base + $ivaAmount - $irpfAmount;

                /* @var SaleDeliveryNoteLine $saleDeliveryNoteLine */
                $saleDeliveryNoteLine
                    ->setDeliveryNote($saleDeliveryNote)
                    ->setUnits($units)
                    ->setPriceUnit($priceUnit)
                    ->setTotal($total)
                    ->setDiscount($discount)
                    ->setDescription($description)
                    ->setIva($iva)
                    ->setIrpf($irpf)
                ;
                $this->em->persist($saleDeliveryNoteLine);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }

                $baseAmountDeliveryNote = $saleDeliveryNote->getBaseAmount() + $total;
                $saleDeliveryNote->setBaseAmount($baseAmountDeliveryNote);
                $this->em->persist($saleDeliveryNote);
                $this->em->flush();
            } else {
                $output->write('<error>Error at row number #'.$rowsRead);
                if (!$priceUnit) {
                    $output->write(' · no price unit found');
                    $errorMessagesArray[] = $printLineMessage.' · no price unit found';
                }
                if (!$iva) {
                    $output->write(' · no iva found');
                    $errorMessagesArray[] = $printLineMessage.' · no iva found';
                }

                if (!$irpf) {
                    $output->write(' · no irpf found');
                    $errorMessagesArray[] = $printLineMessage.' · no irpf found';
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

<?php

namespace AppBundle\Command\Sale;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Sale\SaleDeliveryNote;
use AppBundle\Entity\Sale\SaleInvoice;
use DateTime;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportSaleInvoiceSaleDeliveryNoteCommand.
 *
 * @category Command
 *
 * @author   Rubèn Hierro <info@rubenhierro.com>
 */
class ImportSaleInvoiceSaleDeliveryNoteCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:sale:invoice:sale:delivery:note');
        $this->setDescription('Import sale invoice sale delivery note  from CSV file');
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
            $invoiceId = $this->readColumn(0, $row);
            $deliveryNoteId = $this->readColumn(1, $row);

            $printLineMessage = '#'.$rowsRead.' · '.$invoiceId.' · '.$deliveryNoteId;
            $output->writeln($printLineMessage);

            if ($invoiceId && $deliveryNoteId) {
                $saleInvoice = $this->em->getRepository('AppBundle:Sale\SaleInvoice')->findOneBy([
                    'id' => $invoiceId,
                ]);
                if (!$saleInvoice) {
                    $output->write(' · invoice not found');
                    $errorMessagesArray[] = $printLineMessage.' · invoice not found';
                }
                $saleDeliveryNote = $this->em->getRepository('AppBundle:Sale\SaleDeliveryNote')->findOneBy([
                   'id' => $deliveryNoteId,
                ]);
                if (!$saleDeliveryNote) {
                    $output->write(' · delivery note not found');
                    $errorMessagesArray[] = $printLineMessage.' · delivery note not found';
                }

                /* @var SaleInvoice $saleInvoice
                 * @var SaleDeliveryNote $saleDeliveryNote
                 */
                $saleInvoice->addDeliveryNote($saleDeliveryNote);
                $saleDeliveryNote->addSaleInvoice($saleInvoice);
                $this->em->persist($saleInvoice);
                $this->em->persist($saleDeliveryNote);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
                ++$newRecords;
            } else {
                $output->write('<error>Error at row number #'.$rowsRead);
                if (!$invoiceId) {
                    $output->write(' · no invoice id found');
                    $errorMessagesArray[] = $printLineMessage.' · no invoice id found';
                }
                if (!$deliveryNoteId) {
                    $output->write(' · no delivery note id found');
                    $errorMessagesArray[] = $printLineMessage.' · no delivery note found';
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

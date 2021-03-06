<?php

namespace AppBundle\Command\Partner;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Partner\PartnerUnableDays;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportPartnerUnableDaysCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportPartnerUnableDaysCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:partner:unable:days');
        $this->setDescription('Import partner unable days from CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addOption('dry-run', null, InputOption::VALUE_NONE, 'don\'t persist changes into database');
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
            $begin = $this->dts->convertStringWithDayAndMonthToDateTime($this->readColumn(2, $row));
            $end = $this->dts->convertStringWithDayAndMonthToDateTime($this->readColumn(3, $row));
            $partnerTaxIdentificationNumber = $this->readColumn(4, $row);
            $enterpriseTaxIdentificationNumber = $this->readColumn(5, $row);
            $output->writeln('#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$begin->format('d/m').' · '.$end->format('d/m').' · '.$partnerTaxIdentificationNumber.' · '.$enterpriseTaxIdentificationNumber);
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $enterpriseTaxIdentificationNumber]);
            $partner = $this->em->getRepository('AppBundle:Partner\Partner')->findOneBy([
                'cifNif' => $partnerTaxIdentificationNumber,
                'enterprise' => $enterprise,
            ]);
            if ($begin && $end && $partner && $enterprise) {
                $partnerUnableDays = $this->em->getRepository('AppBundle:Partner\PartnerUnableDays')->findOneBy([
                    'begin' => $begin,
                    'end' => $end,
                    'partner' => $partner,
                ]);
                if (!$partnerUnableDays) {
                    // new record
                    $partnerUnableDays = new PartnerUnableDays();
                    ++$newRecords;
                }
                $partnerUnableDays
                    ->setPartner($partner)
                    ->setBegin($begin)
                    ->setEnd($end)
                ;
                $this->em->persist($partnerUnableDays);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
            } else {
                $output->write('<error>Error at row number #'.$rowsRead);
                if (!$begin) {
                    $output->write(' · no begin found');
                }
                if (!$end) {
                    $output->write(' · no end found');
                }
                if (!$partner) {
                    $output->write(' · no partner found');
                }
                if (!$enterprise) {
                    $output->write(' · no enterprise found');
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
        $endTimestamp = new \DateTime();
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors, $input->getOption('dry-run'));
    }
}

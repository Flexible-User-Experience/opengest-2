<?php

namespace AppBundle\Command;

use AppBundle\Entity\Enterprise;
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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Import CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        while (($row = $this->readRow($fr)) != false) {
            $output->writeln($this->readColumn(8, $row).' · '.$this->readColumn(2, $row));

            $enterprise = $this->em->getRepository('AppBundle:Enterprise')->findOneBy(['taxIdentificationNumber' => $this->readColumn(8, $row)]);

            if (!$enterprise) {
                // new record
                $enterprise = new Enterprise();
                $enterprise
                    ->setTaxIdentificationNumber($this->readColumn(8, $row))
                    ->setBusinessName($this->readColumn(2, $row))
                    ->setName($this->readColumn(1, $row))
                    ->setAddress($this->readColumn(3, $row))
                    ->setCity($this->readColumn(4, $row))
                    ->setPhone1($this->readColumn(9, $row))
                    ->setPhone2($this->readColumn(10, $row))
                    ->setPhone3($this->readColumn(11, $row))
                    ->setFax($this->readColumn(12, $row))
                    ->setEmail($this->readColumn(13, $row))
                    ->setWww($this->readColumn(14, $row))
                    ->setLogo($this->readColumn(16, $row))
                ;
            }

//            $this->em->persist($enterprise);
            ++$rowsRead;
        }

        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

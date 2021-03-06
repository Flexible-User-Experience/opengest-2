<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ReadCsvTestCommand.
 */
class ReadCsvTestCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:read-csv-test');
        $this->setDescription('Read a CSV file');
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
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Print CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        while (false !== ($data = $this->readRow($fr))) {
            echo implode(self::CSV_DELIMITER, $data).PHP_EOL;
            ++$rowsRead;
        }

        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, 0, $beginTimestamp, $endTimestamp);
    }
}

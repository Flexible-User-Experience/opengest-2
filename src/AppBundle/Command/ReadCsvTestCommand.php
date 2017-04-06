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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome
        $output->writeln('<info>Welcome to "Read a CSV file" test command.</info>');

        // Initializations
        $this->init();

        // File validations
        $output->writeln('<comment>loading data, please wait...</comment>');
        $filename = $input->getArgument('filename');
        if (!$this->fss->exists($filename)) {
            throw new InvalidArgumentException('The file '.$filename.' does not exists');
        }

        $fr = fopen($filename, 'r');
        if (!$fr) {
            throw new InvalidArgumentException('The file '.$filename.' exists but can not be readed');
        }

        // Print CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        while (($data = $this->readRow($fr)) !== false) {
            echo implode(self::CSV_DELIMITER, $data).PHP_EOL;
            ++$rowsRead;
        }

        // Print totals
        $endTimestamp = new \DateTime();
        $output->writeln('<comment>'.$rowsRead.' rows read.</comment>');
        $output->writeln('<info>Total ellapsed time: '.$beginTimestamp->diff($endTimestamp)->format('%H:%I:%S').'</info>');
    }
}

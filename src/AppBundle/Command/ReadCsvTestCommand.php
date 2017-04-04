<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ReadCsvTestCommand
 *
 * @package AppBundle\Command
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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
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
        ini_set('auto_detect_line_endings', true);
        $filename = $input->getArgument('filename');
        $fr = fopen($filename, 'r');
        if (!$this->fss->exists($filename)) {
            throw new InvalidArgumentException('The file '.$filename.' does not exists');
        }
        if (!$fr) {
            throw new InvalidArgumentException('The file '.$filename.' exists but can not be readed');
        }

        // Print CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        while (($data = $this->readRow($fr)) !== false) {
            echo implode(self::CSV_DELIMITER, $data).PHP_EOL;
            $rowsRead++;
        }

        // Print totals
        $endTimestamp = new \DateTime();
        $output->writeln($rowsRead.' rows read.');
        $output->writeln('Total ellapsed time: '.$beginTimestamp->diff($endTimestamp)->format('%H:%I:%S'));
        $output->writeln('<info>Finished!</info>');
    }
}

<?php

namespace AppBundle\Command;

use AppBundle\Transformer\LocationsTransformer;
use AppBundle\Transformer\DatesTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractBaseCommand.
 */
abstract class AbstractBaseCommand extends ContainerAwareCommand
{
    const CSV_DELIMITER = ',';
    const CSV_ENCLOSURE = '"';
    const CSV_ESCAPE = '\\';
    const CSV_BATCH_WINDOW = 100;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var Filesystem
     */
    protected $fss;

    /**
     * @var LocationsTransformer
     */
    protected $lts;

    /**
     * @var DatesTransformer
     */
    protected $dts;

    /**
     * Methods.
     */

    /**
     * Command initializer.
     *
     * @return $this
     */
    public function init()
    {
        ini_set('auto_detect_line_endings', true);
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->fss = $this->getContainer()->get('filesystem');
        $this->lts = $this->getContainer()->get('app.locations_transformer');
        $this->dts = $this->getContainer()->get('app.dates_transformer');

        return $this;
    }

    /**
     * Load column data (index) from searched array (row) if exists, else throws an exception.
     *
     * @param int   $index column index
     * @param array $row   data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function readColumn($index, $row)
    {
        if (!array_key_exists($index, $row)) {
            throw new \Exception('Column index '.$index.' doesn\'t exists');
        }

        return '\\N' != $row[$index] ? $row[$index] : null;
    }

    /**
     * Read line (row) from CSV file.
     *
     * @param resource $fr file resource, a valid file pointer to a file successfully opened
     *
     * @return array
     */
    protected function readRow($fr)
    {
        return fgetcsv($fr, 0, self::CSV_DELIMITER, self::CSV_ENCLOSURE, self::CSV_ESCAPE);
    }

    /**
     * Get current timestamp string with format Y/m/d H:i:s.
     *
     * @return string
     *
     * @throws \Exception
     */
    protected function getTimestampString()
    {
        $cm = new \DateTime();

        return $cm->format('Y/m/d H:i:s');
    }

    /**
     * Execute.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return resource
     *
     * @throws InvalidArgumentException
     */
    protected function initialValidation(InputInterface $input, OutputInterface $output)
    {
        // Welcome
        $output->writeln('<info>Welcome to "'.$this->getDescription().'" command.</info>');

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

        return $fr;
    }

    /**
     * @param OutputInterface $output
     * @param int             $rowsRead
     * @param int             $newRecords
     * @param \DateTime       $beginTimestamp
     * @param \DateTime       $endTimestamp
     * @param int             $errors
     * @param bool            $isDryRunModeEnabled
     */
    protected function printTotals(OutputInterface $output, $rowsRead, $newRecords, \DateTime $beginTimestamp, \DateTime $endTimestamp, $errors = 0, $isDryRunModeEnabled = false)
    {
        // Print totals
        if ($isDryRunModeEnabled) {
            $output->writeln('<comment>********************************************************</comment>');
            $output->writeln('<comment>* --dry-run mode enabled (nothing changes in database) *</comment>');
            $output->writeln('<comment>********************************************************</comment>');
        }
        $output->writeln('<comment>'.$rowsRead.' rows read.</comment>');
        $output->writeln('<comment>'.$newRecords.' new records.</comment>');
        $output->writeln('<comment>'.($rowsRead - $newRecords - $errors).' updated records.</comment>');
        if ($errors > 0) {
            $output->writeln('<comment>'.$errors.' errors found</comment>');
        }
        $output->writeln('<info>Total ellapsed time: '.$beginTimestamp->diff($endTimestamp)->format('%H:%I:%S').'</info>');
    }
}

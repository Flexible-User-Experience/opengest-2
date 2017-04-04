<?php

namespace AppBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class AbstractBaseCommand
 *
 * @package AppBundle\Command
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
     * Methods
     */

    /**
     * Command initializer
     *
     * @return $this
     */
    public function init()
    {
        ini_set('auto_detect_line_endings', true);
        $this->em = $this->getContainer()->get('doctrine');
        $this->fss = $this->getContainer()->get('filesystem');

        return $this;
    }

    /**
     * Load column data (index) from searched array (row) if exists, else throws an exception.
     *
     * @param int $index column index
     * @param array $row data
     *
     * @return mixed
     * @throws \Exception
     */
    protected function readColumn($index, $row)
    {
        if (!array_key_exists($index, $row)) {
            throw new \Exception('Column index '.$index.' doesn\'t exists');
        }

        return $row[$index];
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
     */
    protected function getTimestampString()
    {
        $cm = new \DateTime();

        return $cm->format('Y/m/d H:i:s');
    }
}

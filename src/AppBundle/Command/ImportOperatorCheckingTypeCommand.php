<?php

namespace AppBundle\Command;

use AppBundle\Entity\OperatorCheckingType;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportOperatorCheckingTypeCommand.
 *
 * @category Command
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ImportOperatorCheckingTypeCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:operator:checking:type');
        $this->setDescription('Import operator checking type from CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Import CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        while (($row = $this->readRow($fr)) !== false) {
            $output->writeln($this->readColumn(1, $row).' · '.$this->readColumn(2, $row));

            $operatorCheckingType = $this->em->getRepository('AppBundle:OperatorCheckingType')->findOneBy(['name' => $this->readColumn(1, $row)]);
            // new record
            if (!$operatorCheckingType) {
                $operatorCheckingType = new OperatorCheckingType();
                ++$newRecords;
            }
            $operatorCheckingType
                ->setName($this->readColumn(1, $row))
                ->setDescription($this->readColumn(2, $row))
            ;

            $this->em->persist($operatorCheckingType);
            ++$rowsRead;
        }
        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

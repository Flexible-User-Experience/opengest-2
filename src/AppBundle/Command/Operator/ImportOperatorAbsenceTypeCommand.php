<?php

namespace AppBundle\Command\Operator;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Operator\OperatorAbsenceType;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportOperatorAbsenceTypeCommand.
 *
 * @category Command
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ImportOperatorAbsenceTypeCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:operator:absence:type');
        $this->setDescription('Import operator absence type from CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
    }

    /**
     * Execute.
     *
     * @param InputInterface $input
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

        // Import CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        while (false !== ($row = $this->readRow($fr))) {
            $output->writeln($this->readColumn(1, $row).' · '.$this->readColumn(2, $row));

            $operatorAbsenceType = $this->em->getRepository('AppBundle:Operator\OperatorAbsenceType')->findOneBy(['name' => $this->readColumn(1, $row)]);
            if (!$operatorAbsenceType) {
                // new record
                $operatorAbsenceType = new OperatorAbsenceType();
                ++$newRecords;
            }
            $operatorAbsenceType
                ->setName($this->readColumn(1, $row))
                ->setDescription($this->readColumn(2, $row))
            ;
            $this->em->persist($operatorAbsenceType);
            ++$rowsRead;
        }
        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

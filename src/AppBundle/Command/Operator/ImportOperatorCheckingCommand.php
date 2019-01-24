<?php

namespace AppBundle\Command\Operator;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Operator\OperatorChecking;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportOperatorCheckingCommand.
 *
 * @category Command
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ImportOperatorCheckingCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:operator:checking');
        $this->setDescription('Import operator checking from CSV file');
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
        $errors = 0;
        while (false != ($row = $this->readRow($fr))) {
            $begin = \DateTime::createFromFormat('Y-m-d', $this->readColumn(3, $row));
            $end = \DateTime::createFromFormat('Y-m-d', $this->readColumn(4, $row));

            $type = $this->em->getRepository('AppBundle:Operator\OperatorCheckingType')->findOneBy(['name' => $this->readColumn(5, $row)]);

            $operator = $this->em->getRepository('AppBundle:Operator\Operator')->findOneBy(['taxIdentificationNumber' => $this->readColumn(6, $row)]);
            if ($operator && $type && $begin && $end) {
                $output->writeln($this->readColumn(6, $row).' · '.$this->readColumn(3, $row).' · '.$this->readColumn(4, $row).' · '.$this->readColumn(5, $row));
                $operatorChecking = $this->em->getRepository('AppBundle:Operator\OperatorChecking')->findOneBy([
                    'begin' => $begin,
                    'end' => $end,
                    'type' => $type,
                    'operator' => $operator,
                ]);
                if (!$operatorChecking) {
                    // new record
                    $operatorChecking = new OperatorChecking();
                    ++$newRecords;
                }
                $operatorChecking
                    ->setOperator($operator)
                    ->setBegin($begin)
                    ->setEnd($end)
                    ->setType($type)
                ;
                $this->em->persist($operatorChecking);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW) {
                    $this->em->flush();
                }
            } else {
                ++$errors;
                $output->writeln('<error>Error a la fila: '.$rowsRead.'</error>');
            }
            ++$rowsRead;
            $this->em->flush();
        }
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors);
    }
}

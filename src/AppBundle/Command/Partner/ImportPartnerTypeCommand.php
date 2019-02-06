<?php

namespace AppBundle\Command\Partner;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Operator\OperatorAbsence;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportPartnerTypeCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportPartnerTypeCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:partner:type');
        $this->setDescription('Import partner class from CSV file');
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
            $type = $this->em->getRepository('AppBundle:Operator\OperatorAbsenceType')->findOneBy(['name' => $this->readColumn(5, $row)]);
            $operator = $this->em->getRepository('AppBundle:Operator\Operator')->findOneBy(['taxIdentificationNumber' => $this->readColumn(6, $row)]);

            if ($operator && $type && $begin && $end) {
                $output->writeln($this->readColumn(6, $row).' · '.$this->readColumn(3, $row).' · '.$this->readColumn(4, $row).' · '.$this->readColumn(5, $row));

                $operatorAbsence = $this->em->getRepository('AppBundle:Operator\OperatorAbsence')->findOneBy([
                    'begin' => $begin,
                    'end' => $end,
                    'type' => $type,
                    'operator' => $operator,
                ]);
                if (!$operatorAbsence) {
                    // new record
                    $operatorAbsence = new OperatorAbsence();
                    ++$newRecords;
                }
                $operatorAbsence
                    ->setOperator($operator)
                    ->setBegin($begin)
                    ->setEnd($end)
                    ->setType($type)
                ;
                $this->em->persist($operatorAbsence);
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

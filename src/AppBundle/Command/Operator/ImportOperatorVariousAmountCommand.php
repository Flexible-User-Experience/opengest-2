<?php

namespace AppBundle\Command\Operator;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Operator\OperatorVariousAmount;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportOperatorVariousAmountCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportOperatorVariousAmountCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:operator:various:amount');
        $this->setDescription('Import operator various amounts from CSV file');
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
            $operator = $this->em->getRepository('AppBundle:Operator\Operator')->findOneBy(['id' => $this->readColumn(1, $row)]);
            $date = \DateTime::createFromFormat('Y-m-d', $this->readColumn(2, $row));
            $description = $this->readColumn(3, $row);
            if ($operator && $date && $description) {
                $output->writeln($this->readColumn(1, $row).' · '.$this->readColumn(2, $row).' · '.$this->readColumn(3, $row));
                $variousAmount = $this->em->getRepository('AppBundle:Operator\OperatorVariousAmount')->findOneBy([
                    'operator' => $operator,
                    'date' => $date,
                    'description' => $description,
                ]);
                if (!$variousAmount) {
                    // new record
                    ++$newRecords;
                    $variousAmount = new OperatorVariousAmount();
                }
                $variousAmount
                    ->setOperator($operator)
                    ->setDate($date)
                    ->setDescription($description)
                    ->setPriceUnit($this->readColumn(4, $row))
                    ->setUnits($this->readColumn(5, $row))
                ;
                $this->em->persist($variousAmount);
                $this->em->flush();
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

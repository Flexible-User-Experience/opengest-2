<?php

namespace AppBundle\Command\Operator;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Operator\OperatorDigitalTachograph;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportOperatorDigitalTachographCommand.
 *
 * @category Command
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ImportOperatorDigitalTachographCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:operator:digital:tachograph');
        $this->setDescription('Import operator digital tachographs from CSV file');
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
        $rowsRead = 1;
        $newRecords = 0;
        $errors = 0;
        while (false != ($row = $this->readRow($fr))) {
            $operator = $this->em->getRepository('AppBundle:Operator\Operator')->findOneBy(['id' => $this->readColumn(1, $row)]);
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->readColumn(2, $row));
            $file = $this->readColumn(3, $row);
            if ($operator && $date && $file) {
                $output->writeln('#'.$rowsRead.' · '.$operator->getShortFullName().' · '.$date->format('Y-m-d H:i:s').' · '.$file);
                $digitalTachograph = $this->em->getRepository('AppBundle:Operator\OperatorDigitalTachograph')->findOneBy([
                    'operator' => $operator,
                    'createdAt' => $date,
                ]);
                if (!$digitalTachograph) {
                    // new record
                    ++$newRecords;
                    $digitalTachograph = new OperatorDigitalTachograph();
                }
                $digitalTachograph
                    ->setOperator($operator)
                    ->setCreatedAt($date)
                    ->setUploadedFileName($file)
                ;
                $this->em->persist($digitalTachograph);
                $this->em->flush();
            } else {
                ++$errors;
                $output->write('<error>#'.$rowsRead);
                if (!$operator) {
                    $output->write(' · no operator found');
                }
                if (!$date) {
                    $output->write(' · no date found');
                }
                if (!$file) {
                    $output->write(' · no file found');
                }
                $output->writeln('</error>');
            }
            ++$rowsRead;
            $this->em->flush();
        }
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead - 1, $newRecords, $beginTimestamp, $endTimestamp, $errors);
    }
}

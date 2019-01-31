<?php

namespace AppBundle\Command\Enterprise;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Enterprise\ActivityLine;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportEnterpriseCsvCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportActivityLineCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:enterprise:activity:line');
        $this->setDescription('Import enterprise activity lines from CSV file');
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
        while (false != ($row = $this->readRow($fr))) {
            $output->writeln($this->readColumn(0, $row).' · '.$this->readColumn(2, $row));
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['id' => $this->readColumn(1, $row)]);
            if ($enterprise) {
                $name = $this->readColumn(2, $row);
                $activityLine = $this->em->getRepository('AppBundle:Enterprise\ActivityLine')->findOneBy(['name' => $name, 'enterprise' => $enterprise]);
                if (!$activityLine) {
                    // new record
                    $activityLine = new ActivityLine();
                    ++$newRecords;
                }
                $activityLine
                    ->setEnterprise($enterprise)
                    ->setName($name)
                ;
                $this->em->persist($activityLine);
                ++$rowsRead;
                $this->em->flush();
            }
            $this->em->flush();
        }
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

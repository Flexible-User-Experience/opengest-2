<?php

namespace AppBundle\Command\Enterprise;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Enterprise\EnterpriseHolidays;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportEnterpriseHolidayCsvCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportEnterpriseHolidayCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:enterprise:holiday');
        $this->setDescription('Import enterprise holidays from CSV file');
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
            /** @var Enterprise $enterprise */
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['id' => $this->readColumn(1, $row)]);
            $date = $this->readColumn(2, $row);
            if ($enterprise && '0000-00-00' != $date) {
                $date = explode('-', $date);
                $day = new \DateTime();
                $day->setDate($date[0], $date[1], $date[2]);
                $day->setTime(0, 0, 0);
                /** @var EnterpriseHolidays $enterpriseHolidays */
                $enterpriseHolidays = $this->em->getRepository('AppBundle:Enterprise\EnterpriseHolidays')->findOneBy(['day' => $day, 'enterprise' => $enterprise]);
                if (!$enterpriseHolidays) {
                    // new record
                    ++$newRecords;
                    $enterpriseHolidays = new EnterpriseHolidays();
                }
                $enterpriseHolidays
                    ->setEnterprise($enterprise)
                    ->setDay($day)
                    ->setName($this->readColumn(3, $row))
                ;
                ++$rowsRead;
                $this->em->persist($enterpriseHolidays);
                $this->em->flush();
            }
        }
        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

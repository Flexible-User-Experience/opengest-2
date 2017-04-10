<?php

namespace AppBundle\Command;

use AppBundle\Entity\Work;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportWorkCsvCommand.
 */
class ImportWorkCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:work');
        $this->setDescription('Import work from CSV file');
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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome & Initialization & File validations
        $fr = $this->initialValidation($input, $output);

        // Import CSV rows
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        while (($row = $this->readRow($fr)) !== false) {
            $work = $this->em->getRepository('AppBundle:Work')->findOneBy(['name' => $this->readColumn(0, $row)]);
            if (!$work) {
                $work = new Work();

                ++$newRecords;
            }
            $work
                ->setName($this->readColumn(0, $row))
                ->setDate(new \DateTime())
                ->setDescription($this->readColumn(1, $row))
                ->setShortDescription($this->readColumn(2, $row))
                ->setMainImage($this->readColumn(3, $row))
            ;
            $this->em->persist($work);

            ++$rowsRead;
        }

        $this->em->flush();

        // Print totals
        $endTimestamp = new \DateTime();
        $output->writeln('<comment>'.$rowsRead.' rows read.</comment>');
        $output->writeln('<comment>'.$newRecords.' new records.</comment>');
        $output->writeln('<comment>'.($rowsRead - $newRecords).' updated records.</comment>');
        $output->writeln('<info>Total ellapsed time: '.$beginTimestamp->diff($endTimestamp)->format('%H:%I:%S').'</info>');
    }
}

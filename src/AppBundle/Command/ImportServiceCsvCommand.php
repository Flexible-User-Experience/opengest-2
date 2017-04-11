<?php

namespace AppBundle\Command;

use AppBundle\Entity\Service;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportServiceCsvCommand.
 */
class ImportServiceCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:service');
        $this->setDescription('Import service from CSV file');
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
            $service = $this->em->getRepository('AppBundle:Service')->findOneBy(['slug' => $this->readColumn(26, $row)]);
            // new service
            if (!$service) {
                $service = new Service();
                ++$newRecords;
            }
            // update service
            $name = utf8_decode($this->readColumn(8, $row));
            $service
                ->setName($name)
                ->setMainImage($name)
            ;
            $this->em->persist($service);
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

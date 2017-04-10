<?php

namespace AppBundle\Command;

use AppBundle\Entity\VehicleCategory;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportVehicleCategoryCsvCommand.
 */
class ImportVehicleCategoryCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:vehicle-category');
        $this->setDescription('Import vehicle category from CSV file');
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
            $vehicleCategory = $this->em->getRepository('AppBundle:VehicleCategory')->findOneBy(['name' => $this->readColumn(1, $row)]);
            // new vehicle category
            if (!$vehicleCategory) {
                $vehicleCategory = new VehicleCategory();
                ++$newRecords;
            }
            // update vehicle category
            $vehicleCategory
                ->setName($this->readColumn(1, $row))
            ;
            $this->em->persist($vehicleCategory);
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

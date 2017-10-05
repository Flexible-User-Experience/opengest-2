<?php

namespace AppBundle\Command;

use AppBundle\Entity\City;
use AppBundle\Entity\Operator;
use AppBundle\Entity\Province;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportOperatorCommand.
 *
 * @category Command
 *
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class ImportOperatorCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:operator');
        $this->setDescription('Import operator from CSV file');
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
        while (($row = $this->readRow($fr)) != false) {
            $output->writeln($this->readColumn(4, $row).' · '.$this->readColumn(5, $row));

            $province = $this->em->getRepository('AppBundle:Province')->findOneBy(['name' => $this->readColumn(5, $row)]);
            if (!$province) {
                // new record
                $province = new Province();
            }
            $province
                ->setName($this->readColumn(5, $row))
                ->setCode(strtoupper(substr($this->readColumn(5, $row), 0, 1)))
                ->setCountry('ES')
            ;
            $this->em->persist($province);

            $city = $this->em->getRepository('AppBundle:City')->findOneBy(['postalCode' => $this->readColumn(7, $row)]);
            if (!$city) {
                // new record
                $city = new City();
            }
            $city
                ->setName($this->readColumn(4, $row))
                ->setProvince($province)
                ->setPostalCode($this->readColumn(7, $row))
            ;
            $this->em->persist($city);

            $operator = $this->em->getRepository('AppBundle:Operator')->findOneBy(['taxIdentificationNumber' => $this->readColumn(4, $row)]);
            if (!$operator) {
                $operator = new Operator();
            }
            $operator
                ->setEnabled($this->readColumn(3, $row))
                ->setTaxIdentificationNumber($this->readColumn(4, $row))
                ->setName($this->readColumn(5, $row))
                ->setSurname1($this->readColumn(6, $row))
                ->setSurname2($this->readColumn(7, $row))
                ->setAddress($this->readColumn(9, $row))
            ;
        }
        ++$rowsRead;

        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

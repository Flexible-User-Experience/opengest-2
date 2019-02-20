<?php

namespace AppBundle\Command\Setting;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Setting\City;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportCityCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportCityCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:city');
        $this->setDescription('Import city from CSV file by index');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addArgument('name', InputArgument::REQUIRED, 'city name column index');
        $this->addArgument('zip', InputArgument::REQUIRED, 'postal code column index');
        $this->addArgument('province', InputArgument::REQUIRED, 'province name column index');
        $this->addArgument('country', InputArgument::REQUIRED, 'country name column index');
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
            $name = $this->lts->cityNameCleaner($this->readColumn($input->getArgument('name'), $row));
            $postalCode = $this->lts->postalCodeCleaner($this->readColumn($input->getArgument('zip'), $row));
            $provinceName = $this->lts->provinceNameCleaner($this->readColumn($input->getArgument('province'), $row));
            $countryName = $this->lts->countryNameCleaner($this->readColumn($input->getArgument('country'), $row));
            $output->writeln('#'.$rowsRead.' · '.$name.' · '.$postalCode.' · '.$provinceName.' · '.$countryName);
            $countryCode = $this->lts->countryToCode($countryName);
            $province = $this->em->getRepository('AppBundle:Setting\Province')->findOneBy([
                'name' => $provinceName,
                'country' => $countryCode,
            ]);
            if ($province) {
                $city = $this->em->getRepository('AppBundle:Setting\City')->findOneBy(['postalCode' => $postalCode]);
                if (!$city) {
                    // new record
                    $city = new City();
                    ++$newRecords;
                }
                $city
                    ->setName($name)
                    ->setPostalCode($postalCode)
                    ->setProvince($province)
                ;
                $this->em->persist($city);
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

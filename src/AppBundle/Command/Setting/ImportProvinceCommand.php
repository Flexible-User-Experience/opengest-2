<?php

namespace AppBundle\Command\Setting;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Setting\Province;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportProvinceCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportProvinceCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:province');
        $this->setDescription('Import province from CSV file by index');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addArgument('name', InputArgument::REQUIRED, 'province name column index');
        $this->addArgument('country', InputArgument::REQUIRED, 'country name column index');
        $this->addOption('dry-run', null, InputOption::VALUE_NONE, 'don\'t persist changes into database');
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

        // Set counters
        $beginTimestamp = new \DateTime();
        $rowsRead = 0;
        $newRecords = 0;
        $errors = 0;

        // Import CSV rows
        while (false != ($row = $this->readRow($fr))) {
            $name = $this->lts->provinceNameCleaner($this->readColumn($input->getArgument('name'), $row));
            $country = $this->lts->countryNameCleaner($this->readColumn($input->getArgument('country'), $row));
            $output->writeln('#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$name.' · '.$country);
            if ($country) {
                $countryCode = $this->lts->countryToCode($country);
                $province = $this->em->getRepository('AppBundle:Setting\Province')->findOneBy([
                    'name' => $name,
                    'country' => $countryCode,
                ]);
                if (!$province) {
                    // new record
                    $province = new Province();
                    ++$newRecords;
                }
                $province
                    ->setName($name)
                    ->setCode($countryCode.' · '.substr($name, 0, 4))
                    ->setCountry($countryCode)
                ;
                $this->em->persist($province);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->getOption('dry-run')) {
                    $this->em->flush();
                }
            } else {
                $output->writeln('<error>Error at row number #'.$rowsRead.'</error>');
                ++$errors;
            }
            ++$rowsRead;
        }
        if (!$input->getOption('dry-run')) {
            $this->em->flush();
        }

        // Print totals
        $endTimestamp = new \DateTime();
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors, $input->getOption('dry-run'));
    }
}

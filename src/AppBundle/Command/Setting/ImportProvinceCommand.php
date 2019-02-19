<?php

namespace AppBundle\Command\Setting;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Setting\Province;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
            $name = $this->readColumn($input->getArgument('name'), $row);
            $country = $this->readColumn($input->getArgument('country'), $row);
            if (strlen($name) > 0) {
                $name = $this->lts->provinceNameCleaner($name);
            } else {
                $name = '---';
            }
            if (0 == strlen($country)) {
                $country = '---';
            }
            $output->writeln('#'.$rowsRead.' · '.$name.' · '.$country);
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

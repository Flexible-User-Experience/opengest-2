<?php

namespace AppBundle\Command\Enterprise;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Enterprise\EnterpriseTransferAccount;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportEnterpriseTransferAccountCsvCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportEnterpriseTransferAccountCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:enterprise:transfer:account');
        $this->setDescription('Import enterprise transfer accounts from CSV file');
        $this->addArgument('filename', InputArgument::REQUIRED, 'CSV file to import');
        $this->addOption('dry-run', null, InputOption::VALUE_OPTIONAL, 'don\'t persist changes into database');
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
            $name = $this->readColumn(2, $row);
            $output->writeln('#'.$rowsRead.' · ID_'.$this->readColumn(0, $row).' · '.$name);
            /** @var Enterprise $enterprise */
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $this->readColumn(9, $row)]);
            if ($enterprise) {
                /** @var EnterpriseTransferAccount $transferAccount */
                $transferAccount = $this->em->getRepository('AppBundle:Enterprise\EnterpriseTransferAccount')->findOneBy(['name' => $name, 'enterprise' => $enterprise]);
                if (!$transferAccount) {
                    // new record
                    $transferAccount = new EnterpriseTransferAccount();
                    ++$newRecords;
                }
                $transferAccount
                    ->setEnterprise($enterprise)
                    ->setName($name)
                    ->setIban($this->readColumn(3, $row))
                    ->setSwift($this->readColumn(4, $row))
                    ->setBankCode($this->readColumn(5, $row))
                    ->setOfficeNumber($this->readColumn(6, $row))
                    ->setControlDigit($this->readColumn(7, $row))
                    ->setAccountNumber($this->readColumn(8, $row))
                ;
                $this->em->persist($transferAccount);
                if (0 == $rowsRead % self::CSV_BATCH_WINDOW && !$input->hasOption('dry-run')) {
                    $this->em->flush();
                }
            } else {
                $output->writeln('<error>Error a la fila: '.$rowsRead.'</error>');
                ++$errors;
            }
            ++$rowsRead;
        }
        if (!$input->hasOption('dry-run')) {
            $this->em->flush();
        }

        // Print totals
        $endTimestamp = new \DateTime();
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp, $errors, $input->hasOption('dry-run'));
    }
}

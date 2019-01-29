<?php

namespace AppBundle\Command\Enterprise;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Enterprise\EnterpriseTransferAccount;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
            $name = $this->readColumn(2, $row);
            if ($enterprise) {
                /** @var EnterpriseTransferAccount $transferAccount */
                $transferAccount = $this->em->getRepository('AppBundle:Enterprise\EnterpriseTransferAccount')->findOneBy(['name' => $name, 'enterprise' => $enterprise]);
                if (!$transferAccount) {
                    // new record
                    ++$newRecords;
                    $transferAccount = new EnterpriseTransferAccount();
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
                ++$rowsRead;
                $this->em->persist($transferAccount);
                $this->em->flush();
            }
        }
        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

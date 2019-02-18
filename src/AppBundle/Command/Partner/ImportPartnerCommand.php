<?php

namespace AppBundle\Command\Partner;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Partner\Partner;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportPartnerCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportPartnerCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:partner');
        $this->setDescription('Import partner class from CSV file');
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
        $errors = 0;
        while (false != ($row = $this->readRow($fr))) {
            $enterprise = $this->readColumn(40, $row);
            $partnerType = $this->readColumn(41, $row);
            $partnerClass = $this->readColumn(42, $row);
            $enterpriseTransferAccount = $this->readColumn(43, $row);
            if ($enterprise && $partnerType && $partnerClass && $enterpriseTransferAccount) {
                $partnerTaxIdentificationNumber = $this->readColumn(11, $row);
                $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $enterprise]);
                $partnerType = $this->em->getRepository('AppBundle:Partner\PartnerType')->findOneBy(['name' => $partnerType]);
                $partnerClass = $this->em->getRepository('AppBundle:Partner\PartnerClass')->findOneBy(['name' => $partnerClass]);
                $enterpriseTransferAccount = $this->em->getRepository('AppBundle:Enterprise\EnterpriseTransferAccount')->findOneBy(['name' => $enterpriseTransferAccount]);
                if ($enterprise && $partnerType && $partnerClass && $enterpriseTransferAccount) {
                    $partner = $this->em->getRepository('AppBundle:Partner\Partner')->findOneBy([
                        'cifNif' => $partnerTaxIdentificationNumber,
                        'enterprise' => $enterprise,
                        'type' => $partnerType,
                        'class' => $partnerClass,
                        'transferAccount' => $enterpriseTransferAccount,
                    ]);
                    $name = $this->readColumn(5, $row);
                    $output->writeln('#'.$rowsRead.' · '.$partnerTaxIdentificationNumber.' · '.$name.' · '.$enterprise->getName());
                    if (!$partner) {
                        // new record
                        $partner = new Partner();
                        ++$newRecords;
                    }
                    $partner
                        ->setCifNif($partnerTaxIdentificationNumber)
                        ->setEnterprise($enterprise)
                        ->setType($partnerType)
                        ->setClass($partnerClass)
                        ->setTransferAccount($enterpriseTransferAccount)
                        ->setName($name)
                    ;
                    $this->em->persist($partner);
                    if (0 == $rowsRead % self::CSV_BATCH_WINDOW) {
                        $this->em->flush();
                    }
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

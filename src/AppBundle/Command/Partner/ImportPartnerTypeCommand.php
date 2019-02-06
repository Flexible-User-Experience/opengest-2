<?php

namespace AppBundle\Command\Partner;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Partner\PartnerType;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportPartnerTypeCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportPartnerTypeCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:partner:type');
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
        $rowsRead = 1;
        $newRecords = 0;
        $errors = 0;
        while (false != ($row = $this->readRow($fr))) {
            $name = $this->readColumn(1, $row);
            $description = $this->readColumn(2, $row);
            $account = $this->readColumn(3, $row);
            if ($name && $account) {
                $output->writeln('#'.$rowsRead.' · '.$name.' · '.$description.' · '.$account);
                $partnerType = $this->em->getRepository('AppBundle:Partner\PartnerType')->findOneBy(['name' => $name]);
                if (!$partnerType) {
                    // new record
                    $partnerType = new PartnerType();
                    ++$newRecords;
                }
                $partnerType
                    ->setName($name)
                    ->setDescription(($description ? $description : '---'))
                    ->setAccount($account)
                ;
                $this->em->persist($partnerType);
                $this->em->flush();
            } else {
                ++$errors;
                $output->writeln('<error>Error a la fila: '.$rowsRead.'</error>');
            }
            ++$rowsRead;
            $this->em->flush();
        }
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead - 1, $newRecords, $beginTimestamp, $endTimestamp, $errors);
    }
}

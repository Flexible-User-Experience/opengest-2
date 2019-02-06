<?php

namespace AppBundle\Command\Partner;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Partner\PartnerClass;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportPartnerClassCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportPartnerClassCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:partner:class');
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
            if ($name) {
                $output->writeln('#'.$rowsRead.' · '.$name);
                $partnerClass = $this->em->getRepository('AppBundle:Partner\PartnerClass')->findOneBy(['name' => $name]);
                if (!$partnerClass) {
                    // new record
                    $partnerClass = new PartnerClass();
                    ++$newRecords;
                }
                $partnerClass->setName($name);
                $this->em->persist($partnerClass);
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

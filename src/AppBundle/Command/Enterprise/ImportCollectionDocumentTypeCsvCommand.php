<?php

namespace AppBundle\Command\Enterprise;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Enterprise\CollectionDocumentType;
use AppBundle\Entity\Enterprise\Enterprise;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportCollectionDocumentTypeCsvCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportCollectionDocumentTypeCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:enterprise:collection:document:type');
        $this->setDescription('Import enterprise collection document types from CSV file');
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
        $enterprises = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findAll();
        while (false != ($row = $this->readRow($fr))) {
            $output->writeln($this->readColumn(0, $row).' · '.$this->readColumn(1, $row));
            /** @var Enterprise $enterprise */
            foreach ($enterprises as $enterprise) {
                /** @var CollectionDocumentType $searchedCollectionDocumentType */
                $searchedCollectionDocumentType = $this->em->getRepository('AppBundle:Enterprise\CollectionDocumentType')->findOneBy(['enterprise' => $enterprise, 'name' => $this->readColumn(1, $row)]);
                if (!$searchedCollectionDocumentType) {
                    ++$newRecords;
                    $collectionDocumentType = new CollectionDocumentType();
                    $collectionDocumentType
                        ->setName($this->readColumn(1, $row))
                        ->setEnterprise($enterprise)
                        ->setDescription($this->readColumn(2, $row))
                        ->setSitReference($this->readColumn(3, $row))
                    ;
                    $this->em->persist($collectionDocumentType);
                } else {
                    $searchedCollectionDocumentType
                        ->setDescription($this->readColumn(2, $row))
                        ->setSitReference($this->readColumn(3, $row))
                    ;
                }
                $this->em->flush();
            }
            ++$rowsRead;
        }
        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}
<?php

namespace AppBundle\Command\Enterprise;

use AppBundle\Command\AbstractBaseCommand;
use AppBundle\Entity\Enterprise\Enterprise;
use AppBundle\Entity\Enterprise\EnterpriseGroupBounty;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ImportEnterpriseGroupBountyCsvCommand.
 *
 * @category Command
 *
 * @author   David Romaní <david@flux.cat>
 */
class ImportEnterpriseGroupBountyCsvCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:import:enterprise:group:bounty');
        $this->setDescription('Import enterprise group bountys from CSV file');
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
            $enterprise = $this->em->getRepository('AppBundle:Enterprise\Enterprise')->findOneBy(['taxIdentificationNumber' => $this->readColumn(21, $row)]);
            if ($enterprise) {
                $name = $this->readColumn(2, $row);
                /** @var EnterpriseGroupBounty $groupBounty */
                $groupBounty = $this->em->getRepository('AppBundle:Enterprise\EnterpriseGroupBounty')->findOneBy(['group' => $name, 'enterprise' => $enterprise]);
                if (!$groupBounty) {
                    // new record
                    ++$newRecords;
                    $groupBounty = new EnterpriseGroupBounty();
                }
                $groupBounty
                    ->setEnterprise($enterprise)
                    ->setGroup($name)
                    ->setNormalHour($this->readColumn(3, $row))
                    ->setExtraNormalHour($this->readColumn(4, $row))
                    ->setExtraExtraHour($this->readColumn(5, $row))
                    ->setRoadNormalHour($this->readColumn(6, $row))
                    ->setRoadExtraHour($this->readColumn(7, $row))
                    ->setAwaitingHour($this->readColumn(8, $row))
                    ->setNegativeHour($this->readColumn(9, $row))
                    ->setLunch($this->readColumn(10, $row))
                    ->setDinner($this->readColumn(11, $row))
                    ->setOverNight($this->readColumn(12, $row))
                    ->setExtraNight($this->readColumn(13, $row))
                    ->setDiet($this->readColumn(14, $row))
                    ->setInternationalLunch($this->readColumn(15, $row))
                    ->setInternationalDinner($this->readColumn(16, $row))
                    ->setTruckOutput($this->readColumn(18, $row))
                    ->setCarOutput($this->readColumn(19, $row))
                    ->setTransferHour($this->readColumn(20, $row))
                ;
                ++$rowsRead;
                $this->em->persist($groupBounty);
                $this->em->flush();
            }
        }
        $this->em->flush();
        $endTimestamp = new \DateTime();
        // Print totals
        $this->printTotals($output, $rowsRead, $newRecords, $beginTimestamp, $endTimestamp);
    }
}

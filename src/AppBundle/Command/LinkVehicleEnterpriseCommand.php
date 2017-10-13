<?php

namespace AppBundle\Command;

use AppBundle\Entity\Enterprise;
use AppBundle\Entity\Vehicle;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LinkVehicleEnterpriseCommand
 *
 * @category Command
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class LinkVehicleEnterpriseCommand extends AbstractBaseCommand
{
    protected function configure()
    {
        $this->setName('app:link:vehicle:enterprise');
        $this->setDescription('Link vehicle and enterprise');
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
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome
        $output->writeln('<info>Welcome to "'.$this->getDescription().'" command.</info>');

        // Initializations
        $this->init();

        $enterprise = $this->em->getRepository('AppBundle:Enterprise')->findOneBy(['taxIdentificationNumber' => Enterprise::GRUAS_ROMANI_TIN]);
        if (!$enterprise) {
            $output->writeln('<error>No enterprise found</error>');
        } else {
            $vehicles = $this->em->getRepository('AppBundle:Vehicle')->findEnabledSortedByName();
            /** @var Vehicle $vehicle */
            foreach ($vehicles as $vehicle) {
                $output->writeln($vehicle->getId().' · '.$vehicle->getName());
                $vehicle->setEnterprise($enterprise);
            }

            $this->em->flush();
        }
    }
}

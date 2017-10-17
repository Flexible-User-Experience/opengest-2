<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;

/**
 * Class NotificationVehicleCheckingCommand
 *
 * @category Command
 * @author   Wils Iglesias <wiglesias83@gmail.com>
 */
class NotificationVehicleCheckingCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:notification:vehicle-checking');
        $this->setDescription('Send vehicle checking notification before to be invalid');
    }

    /**
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
        $output->writeln('<info>Welcome to "'.$this->getName().'" command.</info>');

        // Get invailid entities
        $vcr = $this->getContainer()->get('app.repositories_manager')->getVehicleCheckingRepository();
        $entities = $vcr->getItemsInvalidByEnabledVehicle();
        $output->writeln('<comment>Invalid entities</comment>');
    }
}

<?php

namespace AppBundle\Command;

use AppBundle\Entity\Vehicle\VehicleChecking;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class NotificationVehicleCheckingCommand.
 *
 * @category Command
 *
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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome
        $output->writeln('<info>Welcome to "'.$this->getName().'" command.</info>');

        // Get invailid entities
        $vcr = $this->getContainer()->get('app.repositories_manager')->getVehicleCheckingRepository();
        $entities = $vcr->getItemsInvalidByEnabledVehicle();
        $output->writeln('<comment>Invalid entities</comment>');
        /** @var VehicleChecking $entity */
        foreach ($entities as $entity) {
            $output->writeln($entity->getId().' '.$entity->getVehicle()->getName().' '.$entity->getEnd()->format('d-m-Y'));
        }
        if (count($entities) > 0) {
            $this->getContainer()->get('app.notification')->sendVehicleCheckingInvalidNotification($entities);
        }

        // Get before to be invalid entities
        $entities = $vcr->getItemsBeforeToBeInvalidByEnabledVehicle();
        $output->writeln('<comment>Before to be invalid entities</comment>');
        /** @var VehicleChecking $entity */
        foreach ($entities as $entity) {
            $output->writeln($entity->getId().' '.$entity->getVehicle()->getName().' '.$entity->getEnd()->format('d-m-Y'));
        }
        if (count($entities) > 0) {
            $this->getContainer()->get('app.notification')->sendVehicleCheckingBeforeToBeInvalidNotification($entities);
        }
    }
}

<?php

namespace AppBundle\Command;

use AppBundle\Entity\OperatorChecking;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class NotificationOperatorCheckingCommand.
 */
class NotificationOperatorCheckingCommand extends AbstractBaseCommand
{
    /**
     * Configure.
     */
    protected function configure()
    {
        $this->setName('app:notification:operator-checking');
        $this->setDescription('Send operator checking notification before to be invalid');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Welcome
        $output->writeln('<info>Welcome to "'.$this->getName().'" command.</info>');

        // Get entities
        $ocr = $this->getContainer()->get('app.repositories_manager')->getOperatorCheckingRepository();
        $entities = $ocr->getItemsInvalid();
        $output->writeln('<comment>Invalid entities</comment>');
        /** @var OperatorChecking $entity */
        foreach ($entities as $entity) {
            $output->writeln($entity->getId().' '.$entity->getOperator()->getFullName().' '.$entity->getEnd()->format('d-m-Y'));
        }

        $entities = $ocr->getItemsBeforeToBeInvalid();
        $output->writeln('<comment>Before to be invalid entities</comment>');
        /** @var OperatorChecking $entity */
        foreach ($entities as $entity) {
            $output->writeln($entity->getId().' '.$entity->getOperator()->getFullName().' '.$entity->getEnd()->format('d-m-Y'));
        }
    }
}

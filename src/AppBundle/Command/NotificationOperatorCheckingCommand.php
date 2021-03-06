<?php

namespace AppBundle\Command;

use AppBundle\Entity\Operator\OperatorChecking;
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

        // Get invalid entities
        $ocr = $this->getContainer()->get('app.repositories_manager')->getOperatorCheckingRepository();
        $entities = $ocr->getItemsInvalidByEnabledOperator();
        $output->writeln('<comment>Invalid entities</comment>');
        /** @var OperatorChecking $entity */
        foreach ($entities as $entity) {
            $output->writeln($entity->getId().' '.$entity->getOperator()->getFullName().' '.$entity->getEnd()->format('d-m-Y'));
            if ($entity->getOperator()->getEmail()) {
                $this->getContainer()->get('app.notification')->sendToOperatorInvalidCheckingNotification($entity);
            }
        }

        if (count($entities) > 0) {
            $this->getContainer()->get('app.notification')->sendOperatorCheckingInvalidNotification($entities);
        }

        // Get before to be invalid entities
        $entities = $ocr->getItemsBeforeToBeInvalidByEnabledOperator();
        $output->writeln('<comment>Before to be invalid entities</comment>');
        /** @var OperatorChecking $entity */
        foreach ($entities as $entity) {
            $output->writeln($entity->getId().' '.$entity->getOperator()->getFullName().' '.$entity->getEnd()->format('d-m-Y'));
            if ($entity->getOperator()->getEmail()) {
                $this->getContainer()->get('app.notification')->sendToOperatorBeforeToBeInvalidCheckingNotification($entity);
            }
        }

        if (count($entities) > 0) {
            $this->getContainer()->get('app.notification')->sendOperatorCheckingBeforeToBeInvalidNotification($entities);
        }
    }
}

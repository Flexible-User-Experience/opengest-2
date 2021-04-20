<?php

namespace AppBundle\Service;

use AppBundle\Entity\Web\ContactMessage;
use AppBundle\Entity\Operator\OperatorChecking;
use AppBundle\Entity\Vehicle\VehicleChecking;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class NotificationService
{
    /**
     * @var CourierService
     */
    private $messenger;

    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var string Mailer Destination
     */
    private $amd;

    /**
     * @var string URL base
     */
    private $urlBase;

    /**
     * Methods.
     */

    /**
     * @param CourierService $messenger
     * @param Environment    $twig
     * @param string         $amd
     * @param string         $urlBase
     */
    public function __construct(CourierService $messenger, Environment $twig, string $amd, string $urlBase)
    {
        $this->messenger = $messenger;
        $this->twig = $twig;
        $this->amd = $amd;
        $this->urlBase = $urlBase;
    }

    /**
     * Send a common notification mail to frontend user.
     *
     * @param ContactMessage $contactMessage
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendCommonUserNotification(ContactMessage $contactMessage): int
    {
        return $this->messenger->sendEmail(
            $this->amd,
            $contactMessage->getEmail(),
            'Notificació pàgina web '.$this->urlBase,
            $this->twig->render(':Mails:common_user_notification.html.twig', array(
                'contact' => $contactMessage,
            ))
        );
    }

    /**
     * Send a contact form notification to admin user.
     *
     * @param ContactMessage $contactMessage
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendContactAdminNotification(ContactMessage $contactMessage): int
    {
        return $this->messenger->sendEmail(
            $this->amd,
            $this->amd,
            'Missatge de contacte pàgina web '.$this->urlBase,
            $this->twig->render(':Mails:contact_form_admin_notification.html.twig', array(
                'contact' => $contactMessage,
            ))
        );
    }

    /**
     * @param array|OperatorChecking[] $entities
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendOperatorCheckingInvalidNotification(array $entities): void
    {
        $this->messenger->sendEmail(
            $this->amd,
            $this->amd,
            'Avís de revisions d\'operaris caducades avui pàgina web '.$this->urlBase,
            $this->twig->render(':Mails:operators_checking_invalid_admin_notification.html.twig', array('entities' => $entities))
        );
    }

    /**
     * @param array|OperatorChecking[] $entities
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendOperatorCheckingBeforeToBeInvalidNotification(array $entities): void
    {
        $this->messenger->sendEmail(
            $this->amd,
            $this->amd,
            'Avís de revisions d\'operaris pedent de caducar pàgina web '.$this->urlBase,
            $this->twig->render(':Mails:operators_checking_before_to_be_invalid_notification.html.twig', array('entities' => $entities))
        );
    }

    /**
     * @param OperatorChecking $entity
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendToOperatorInvalidCheckingNotification(OperatorChecking $entity): void
    {
        $this->messenger->sendEmail(
            $this->amd,
            $entity->getOperator()->getEmail(),
            'Avís de revisió caducada',
            $this->twig->render(':Mails:operator_invalid_notification.html.twig', array('operatorChecking' => $entity))
        );
    }

    /**
     * @param OperatorChecking $entity
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendToOperatorBeforeToBeInvalidCheckingNotification(OperatorChecking $entity): void
    {
        $this->messenger->sendEmail(
            $this->amd,
            $entity->getOperator()->getEmail(),
            'Avís de revisió a punt de caducar',
            $this->twig->render(':Mails:operator_before_to_be_invalid_notification.html.twig', array('operatorChecking' => $entity))
        );
    }

    /**
     * @param array|VehicleChecking[] $entities
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendVehicleCheckingInvalidNotification(array $entities): void
    {
        $this->messenger->sendEmail(
            $this->amd,
            $this->amd,
            'Avís de revisions de vehicles caducades avui pàgina web '.$this->urlBase,
            $this->twig->render(':Mails:vehicles_checking_invalid_admin_notification.html.twig', array('entities' => $entities))
        );
    }

    /**
     * @param array|VehicleChecking[] $entities
     *
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function sendVehicleCheckingBeforeToBeInvalidNotification(array $entities): void
    {
        $this->messenger->sendEmail(
            $this->amd,
            $this->amd,
            'Avís de revisions de vehicles pedent de caducar pàgina web '.$this->urlBase,
            $this->twig->render(':Mails:vehicles_checking_before_to_be_invalid_notification.html.twig', array('entities' => $entities))
        );
    }
}

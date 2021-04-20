<?php

namespace AppBundle\Service;

use Swift_Mailer;
use Swift_Message;

class CourierService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * Methods.
     */

    /**
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string      $from
     * @param string      $to
     * @param string      $subject
     * @param string      $body
     * @param string|null $replyAddress
     *
     * @return int
     */
    public function sendEmail(string $from, string $to, string $subject, string $body, ?string $replyAddress = null): int
    {
        $message = new Swift_Message();
        $message
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body)
            ->setCharset('UTF-8')
            ->setContentType('text/html');
        if (!is_null($replyAddress)) {
            $message->setReplyTo($replyAddress);
        }

        return $this->mailer->send($message);
    }
}

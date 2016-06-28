<?php

namespace Bako\Laravel\MailTester\Services;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;

class SendTestMail
{
    protected $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($email, $subject, $body)
    {
        $this->mailer->send([], [],
            function (Message $message) use ($email, $subject, $body) {
                $message->to($email);
                $message->subject($subject);
                $message->setBody($body);
            }
        );
    }
}

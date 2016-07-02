<?php

namespace Bako\Laravel\MailTester\Services;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Mail\MailQueue;
use Illuminate\Mail\Message;
use Illuminate\Contracts\Console\Kernel as Artisan;

class SendTestMail
{
    protected $mailer;
    protected $mailerQueue;
    protected $artisan;

    public function __construct(Mailer $mailer, 
                                MailQueue $mailerQueue,
                                Artisan $artisan)
    {
        $this->mailer = $mailer;
        $this->mailerQueue = $mailerQueue;
        $this->artisan = $artisan;
    }

    public function send($email, $subject, $body, $queue, $view)
    {
        if ( $queue ) {
            $this->sendQueueMail($email, $subject, $body, $view);            
            return true;
        }
        
        $this->sendRegularMail($email, $subject, $body, $view);
        return true;
    }
    
    private function sendRegularMail( $email, $subject, $body, $view )
    {
        $this->mailer->send($view, [],
            function (Message $message) use ($email, $subject, $body, $view) {
                $message->to($email);
                $message->subject($subject);
                
                if (!$view)
                    $message->setBody($body);
            }
        );        
    } 
    
    private function sendQueueMail( $email, $subject, $body, $view )
    {
        $this->mailerQueue->queue($view, [],
            function (Message $message) use ($email, $subject, $body, $view) {
                $message->to($email);
                $message->subject($subject);
                
                if (!$view)
                    $message->setBody($body);
            },
            'laravel-test-email-queue'
        );        
            
        $this->artisan->call('queue:work', ['--queue'=>'laravel-test-email-queue']);
    } 
}

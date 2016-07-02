<?php

namespace Bako\Laravel\MailTester\Commands;

use Bako\Laravel\MailTester\Services\SendTestMail;
use Bako\Laravel\MailTester\Exceptions\MailTestFailedException;
use Illuminate\Console\Command;

class MailTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test 
                                {email : Email address to be sent to} 
                                {--S|subject=Test : Email address subject} 
                                {--B|body=Test : Email address body} 
                                {--Q|queue : Whether the send of email should be via queue}
                                {--view= : Test email from view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test email to provided address';

    protected $emailTester;

    public function __construct(SendTestMail $emailTester)
    {
        parent::__construct();

        $this->emailTester = $emailTester;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $subject = $this->option('subject');
        $body = $this->option('body');
        $queue = $this->option('queue');
        $view = $this->option('view') ?: [] ;
        
        try {
            $this->emailTester->send($email, $subject, $body, $queue, $view);
            
            $this->info('Test email is succesfully sent. Please check your inbox or spam folder.');
        } catch (MailTestFailedException $exception) {
            $this->error($exception->getMessage());
        }
    }
}

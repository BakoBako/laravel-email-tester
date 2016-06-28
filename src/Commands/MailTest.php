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
    protected $signature = 'mail:test {email} {subject?} {body?}';

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
        $subject = $this->argument('subject', 'Test');
        $body = $this->argument('body', 'Test');
        
        try {
            $this->emailTester->send($email, $subject, $body);
            
            $this->info('Test email is succesfully sent. Please check your inbox or spam folder.');
        } catch (MailTestFailedException $exception) {
            $this->error($exception->getMessage());
        }
    }
}

<?php

namespace Bako\Laravel\MailTester;

use Bako\Laravel\MailTester\Commands\MailTest;
use Illuminate\Support\ServiceProvider;

class MailTesterProvider extends ServiceProvider
{     
    /**
     * Bootstrap any application services.
     */
    public function register()
    {
        $this->commands(MailTest::class);
    }
}

<?php

namespace Bako\Laravel\MailTester\ServiceProviders;

use Bako\Laravel\MailTester\Services\SendTestMail;
use Illuminate\Support\ServiceProvider;

class MailTesterProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->commands(SendTestMail::class);
    }
}

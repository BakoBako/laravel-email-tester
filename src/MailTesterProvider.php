<?php

namespace Bako\Laravel\MailTester;

use Bako\Laravel\MailTester\Services\SendTestMail;
use Illuminate\Support\ServiceProvider;

class MailTesterProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;    
    
    /**
     * Bootstrap any application services.
     */
    public function register()
    {
        $this->commands(SendTestMail::class);
    }
}

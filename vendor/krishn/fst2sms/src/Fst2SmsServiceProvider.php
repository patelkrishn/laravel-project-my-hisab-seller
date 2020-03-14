<?php

namespace Krishn\Fst2Sms;

use Illuminate\Support\ServiceProvider;
use Krishn\Fst2Sms\Providers\Fast2Sms;

class Fst2SmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
           
    }

    public function register()
    {
        $this->app->bind('fst2sms',function(){

            return new Fast2Sms();
    
            });
    }
}
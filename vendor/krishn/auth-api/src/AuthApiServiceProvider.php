<?php

namespace Krishn\AuthApi;

use Illuminate\Support\Facades\Blade;
use Krishn\AuthApi\Providers\AuthApi;
use Illuminate\Support\ServiceProvider;

class AuthApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
           
    }

    public function register()
    {
        $this->app->bind('authapi',function(){

            return new AuthApi();
    
            });
            Blade::directive('guestApi', function () {
                return "<?php if(AuthApi::check()=='Unauthenticated'){ ?>";
            });
            Blade::directive('guestElse', function () {
                return "<?php }else{ ?>";
            });
            Blade::directive('endGuestApi', function () {
                return "<?php } ?>";
            });
    }
}
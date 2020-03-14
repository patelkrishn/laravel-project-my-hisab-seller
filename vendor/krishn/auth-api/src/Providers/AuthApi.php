<?php

namespace Krishn\AuthApi\Providers;
use Krishn\AuthApi\Providers\AuthApiProvider;

class AuthApi extends AuthApiProvider
{
    public function appUrl()
    {
        echo  $this->app_url;
    }
    
    public function check()
    {
        if ($this->message == 'Unauthenticated.') {
            return 'Unauthenticated';
        }else{
            return 'Authenticated';
        }
    }

    public function id()
    {
        if ($this->check() == 'Authenticated') {
            return $this->response->id;
        }else {
            return $this->check();
        }
    }

    public function name()
    {
        if ($this->check() == 'Authenticated') {
            return $this->response->name;
        }else {
            return $this->check();
        }
    }

    public function me()
    {
        if ($this->check() == 'Authenticated') {
            return $this->response;
        }else {
            return $this->check();
        }
    }

    public function email()
    {
        if ($this->check() == 'Authenticated') {
            return $this->response->email;
        }else {
            return $this->check();
        }
    }

    public function mobile()
    {
        if ($this->check() == 'Authenticated') {
            return $this->response->mobile;
        }else {
            return $this->check();
        }
    }
}
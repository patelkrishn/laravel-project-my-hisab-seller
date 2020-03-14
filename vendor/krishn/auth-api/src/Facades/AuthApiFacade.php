<?php 

namespace Krishn\AuthApi\Facades;

use Illuminate\Support\Facades\Facade;

class AuthApiFacade extends Facade
{
	protected static function getFacadeAccessor()
    {
        return 'authapi';
    }
}
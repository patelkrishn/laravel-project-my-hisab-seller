<?php 

namespace Krishn\Fst2Sms\Facades;

use Illuminate\Support\Facades\Facade;

class Fst2SmsFacade extends Facade
{
	protected static function getFacadeAccessor()
    {
        return 'fst2sms';
    }
}
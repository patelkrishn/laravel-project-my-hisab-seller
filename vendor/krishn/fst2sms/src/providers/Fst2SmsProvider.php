<?php

namespace Krishn\Fst2Sms\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Manager;

class Fst2SmsProvider
{
        protected $authorization;
	public function __construct(){
        // $this->request = $request;
        $this->authorization = env('FST2SMS_AUTHORIZATION_KEY');
		
	}
}
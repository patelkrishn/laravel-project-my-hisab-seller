<?php

namespace Krishn\Fst2Sms\Providers;
use Krishn\Fst2Sms\Providers\Fst2SmsProvider;

class Fast2Sms extends Fst2SmsProvider
{

    private $parameters = null;
    
    public function getAuthorization()
    {
        echo  $this->authorization;
    }
    public function getWalletBalance()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/wallet",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_HTTPHEADER => array(
            "authorization: ".$this->authorization
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return "cURL Error #:" . $err;
        } else {
        return $response;
        }
    }
    public function getTempletId()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/quick-templates?authorization=".$this->authorization,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        return "cURL Error #:" . $err;
        } else {
        return $response;
        }
    }
    public function prepare($params = array()){
        $defaults = array(
            "sender_id" => NULL,
            "language" => NULL,
            "route" => NULL,
            "numbers" => NULL,
            "message" => NULL,
            "variables" => NULL,
            "variables_values" => NULL
        );
        $_p = array_merge($defaults, $params);
        foreach ($_p as $key => $value) {

            if ($value == NULL) {
                
                throw new \Exception(' \''.$key.'\' parameter not specified in array passed in prepare() method');
                
                return false;
            }
        }
        $this->parameters = $_p;
        return $this;
    }
    
    public function send(){
        
        // dd($this->parameters);
        if ($this->parameters == null) {
            throw new \Exception("prepare() method not called");
        }
        return $this->sendingQuickTransactional();
    }
    public function sendingQuickTransactional()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($this->parameters),
          CURLOPT_HTTPHEADER => array(
            "authorization: ".$this->authorization,
            "cache-control: no-cache",
            "accept: */*",
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
    }
    
}
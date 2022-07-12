<?php

namespace App\providers;

use InvalidArgumentException;

use App\providers\Provider;

class Discord extends Provider 
{
    public function __construct($client_id, $client_secret, $redirect_uri, $scope, $options = [], $app_name = "")
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $options, $app_name);
        $this->auth_url = AUTH_URL_DS; 
        $this->access_token_url = ACCESS_TOKEN_URL_DS;
        $this->user_url = USER_URL_DS;
    }

    public function getUser($access_token)
    {
        //$access_token = $this->getAccessToken($code);
        $url = $this->user_url;
        
        $this->options = array(
            "http" => array(
                "method" => "GET",
                "header" => "Authorization: Bearer " . $access_token
            )
        );

        $context = stream_context_create($this->options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);

        if(!$access_token){
            throw new InvalidArgumentException("Invalid token");
        }

        return $result['username'];
    }
}
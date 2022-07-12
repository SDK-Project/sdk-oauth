<?php

namespace App\providers;

use InvalidArgumentException;

use App\providers\Provider;

class Github extends Provider
{
    public function __construct($client_id, $client_secret, $redirect_uri, $scope, $options = [], $app_name = "")
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $options, $app_name);
        $this->auth_url = AUTH_URL_GIT; 
        $this->access_token_url = ACCESS_TOKEN_URL_GIT;
        $this->user_url = USER_URL_GIT;
    }

    public function getUser($access_token)
    {
        $url = $this->user_url;
        
        $this->options = array(
            "http" => array(
                "method" => "GET",
                "header" => "User-Agent: $this->app_name\r\nAuthorization: token " . $access_token
            )
        );

        $context = stream_context_create($this->options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);

        if(!$access_token){
            throw new InvalidArgumentException("Invalid token");
        }

        return $result['login'];
    }
}
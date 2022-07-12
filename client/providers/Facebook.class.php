<?php

namespace App\providers;

use App\providers\Provider;

class Facebook extends Provider
{
    public function __construct($client_id, $client_secret, $redirect_uri, $scope, $options = [], $app_name = "")
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $options, $app_name);
        $this->auth_url = AUTH_URL_FB; 
        $this->access_token_url = ACCESS_TOKEN_URL_FB;
        $this->user_url = USER_URL_FB;
    }
}
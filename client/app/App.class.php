<?php

namespace App;

use App\providers\Provider;

class App extends Provider
{
    public function __construct($client_id, $client_secret, $redirect_uri, $auth_url, $access_token_url, $user_url, $options)
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $auth_url, $access_token_url, $user_url, $options);
    }
}
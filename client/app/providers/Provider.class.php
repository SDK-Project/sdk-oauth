<?php

namespace App\providers;

abstract class Provider
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $auth_url;
    protected $access_token_url;
    protected $options;

    public function __construct($client_id, $client_secret, $redirect_uri, $auth_url, $access_token_url, $user_url, $options = [])
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;

        $this->redirect_uri = $redirect_uri;

        $this->auth_url = $auth_url;
        $this->access_token_url = $access_token_url;
        $this->user_url = $user_url;

        $this->options = $options;
    }
}
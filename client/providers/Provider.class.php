<?php

namespace App\providers;

use InvalidArgumentException;

abstract class Provider
{
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;
    protected $scope;
    protected $auth_url;
    protected $access_token_url;
    protected $user_url;
    protected $options;
    protected $app_name;

    public function __construct($client_id, $client_secret, $redirect_uri, $scope, $options = [], $app_name = "")
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;

        $this->scope = $scope;
        $this->options = $options;

        $this->app_name = $app_name;
    }

    public function getAuthUrl()
    {
        $queryParams = http_build_query(array(
            "client_id" => $this->client_id,
            "redirect_uri" => $this->redirect_uri,
            "response_type" => "code",
            "scope" => $this->scope,
            "state" => bin2hex(random_bytes(16))
        ));

        if(empty($queryParams)){
            return;
        }

        return $this->auth_url."?{$queryParams}";
    }

    public function getAccessToken($code)
    {
        $specifParams = [
            "grant_type" => "authorization_code",
            "code" => $code
        ];

        $data = http_build_query(array_merge([
            "redirect_uri" => $this->redirect_uri,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret
        ], $specifParams));

        $url = $this->access_token_url;

        $this->options = array(
            "http" => array(
                "method" => "POST",
                "header" => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json",
                "content" => $data
            )
        );

        $context = stream_context_create($this->options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);

        if(!$code){
            throw new InvalidArgumentException("Invalid code");
        }

        return $result['access_token'];
    }

    public function getUser($access_token)
    {
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

        return $result['name'];
    }
}
<?php

namespace App\providers;

use InvalidArgumentException;

use App\providers\Provider;

class Serv extends Provider
{
    public function __construct($client_id, $client_secret, $redirect_uri, $scope, $options = [], $app_name = "")
    {
        parent::__construct($client_id, $client_secret, $redirect_uri, $scope, $options, $app_name);
        $this->auth_url = AUTH_URL_SERV; 
        $this->access_token_url = ACCESS_TOKEN_URL_SERV;
        $this->user_url = USER_URL_SERV;
    }

    public function getAccessToken($code)
    {
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $specifParams = [
                "grant_type" => "password",
                "username" => $_POST["username"],
                "password" => $_POST["password"]
            ];
        } else {
            $specifParams = [
                "grant_type" => "authorization_code",
                "code" => $code
            ];
        }

        $data = http_build_query(array_merge([
            "redirect_uri" => $this->redirect_uri,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret
        ], $specifParams));

        $url = $this->access_token_url."?{$data}";

        $result = file_get_contents($url);
        $result = json_decode($result, true);

        /*if(!$code){
            throw new InvalidArgumentException("Invalid code");
        }*/

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

        return $result['lastname'];
    }
}
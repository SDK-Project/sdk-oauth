<?php

function login()
{
    $queryParams= http_build_query(array(
        "client_id" => "621e3b8d1f964",
        "redirect_uri" => "http://localhost:8081/callback",
        "response_type" => "code",
        "scope" => "read,write",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "
        <form action='callback' method='POST'>
        <input type='text' name='username'>
        <input type='text' name='password'>
        <input type='submit' value='Login'>
        </form>
    ";
    echo "<a href=\"http://localhost:8080/auth?{$queryParams}\">Se connecter via Oauth Server</a><br>";

    $queryParams= http_build_query(array(
        "client_id" => "2332321786915136",
        "redirect_uri" => "http://localhost:8081/fb_callback",
        "response_type" => "code",
        "scope" => "public_profile,email",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a href=\"https://www.facebook.com/v2.10/dialog/oauth?{$queryParams}\">Se connecter via Facebook</a><br>";

    $queryParams= http_build_query(array(
        "client_id" => "b6111aea773eeced7865",
        "redirect_uri" => "http://localhost:8081/git_callback",
        "response_type" => "code",
        "scope" => "user",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a href=\"https://github.com/login/oauth/authorize?{$queryParams}\">Se connecter via Github</a><br>";

    $queryParams= http_build_query(array(
        "client_id" => "989170106129059901",
        "redirect_uri" => "http://localhost:8081/ds_callback",
        "response_type" => "code",
        "scope" => "connections",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a href=\"https://discord.com/api/oauth2/authorize?{$queryParams}\">Se connecter via Discord</a><br>";

    $queryParams= http_build_query(array(
        "client_id" => "727904560873-1im2ajo9g79bp0tugf7nad4t2pvpkrfs.apps.googleusercontent.com",
        "redirect_uri" => "http://localhost:8081/go_callback",
        "response_type" => "code",
        "scope" => "profile",
        "state" => bin2hex(random_bytes(16))
    ));
    echo "<a href=\"https://accounts.google.com/o/oauth2/auth?{$queryParams}\">Se connecter via Google</a>";
}

function callback()
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
            "code" => $_GET["code"]
        ];
    }

    $clientId = "621e3b8d1f964";
    $clientSecret = "621e3b8d1f966";
    $redirectUri = "http://localhost:8081/callback";

    $data = http_build_query(array_merge([
        "redirect_uri" => $redirectUri,
        "client_id" => $clientId,
        "client_secret" => $clientSecret
    ], $specifParams));

    $url = "http://oauth-server:8080/token?{$data}";
    $result = file_get_contents($url);
    $result = json_decode($result, true);
    $accessToken = $result['access_token'];

    $url = "http://oauth-server:8080/me";
    $options = array(
            'http' => array(
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $accessToken
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    echo "Hello {$result['lastname']}";
}

/*========= PROVIDER FACEBOOK =========*/
function fbcallback()
{
    $specifParams = [
        "grant_type" => "authorization_code",
        "code" => $_GET["code"]
    ];

    $clientId = "2332321786915136";
    $clientSecret = "b767a3113b9d57571eeea5949438bdc6";
    $redirectUri = "http://localhost:8081/fb_callback";

    $data = http_build_query(array_merge([
        "redirect_uri" => $redirectUri,
        "client_id" => $clientId,
        "client_secret" => $clientSecret
    ], $specifParams));

    $url = "https://graph.facebook.com/v2.10/oauth/access_token?{$data}";
    $result = file_get_contents($url);
    $result = json_decode($result, true);
    $accessToken = $result['access_token'];

    $url = "https://graph.facebook.com/v2.10/me";
    $options = array(
            'http' => array(
            'method' => 'GET',
            'header' => 'Authorization: Bearer ' . $accessToken
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    //var_dump($result);
    echo "Hello {$result['name']}";
}

/*========= PROVIDER GITHUB =========*/
function gitcallback()
{
    $specifParams = [
        "grant_type" => "authorization_code",
        "code" => $_GET["code"]
    ];

    $clientId = "b6111aea773eeced7865";
    $clientSecret = "26e0e2e809c7a9ccc9080708e410b9df88ad9038";
    $redirectUri = "http://localhost:8081/git_callback";

    $data = http_build_query(array_merge([
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "redirect_uri" => $redirectUri
    ], $specifParams));

    $url = "https://github.com/login/oauth/access_token?{$data}";
    $options = array(
            'http' => array(
            'header' => "Accept: application/json"
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    $accessToken = $result['access_token'];

    $url = "https://api.github.com/user";
    $options = array(
            'http' => array(
            'method' => 'GET',
            'header' => "User-Agent: github\r\nAuthorization: token " . $accessToken
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    //var_dump($result);
    echo "Hello {$result['login']}";
}

/*========= PROVIDER DISCORD =========*/
function dscallback()
{
    $specifParams = [
        "grant_type" => "authorization_code",
        "code" => $_GET["code"]
    ];

    $clientId = "989170106129059901";
    $clientSecret = "TryiBDMR4SuVDpHkd5J5Wc0XFSCM4POG";
    $redirectUri = "http://localhost:8081/ds_callback";

    $data = http_build_query(array_merge([
        "client_id" => $clientId,
        "client_secret" => $clientSecret,
        "redirect_uri" => $redirectUri
    ], $specifParams));

    $url = "https://discord.com/api/v10/oauth2/token";
    $options = array(
            'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $data
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    $accessToken = $result['access_token'];

    $url = "https://discord.com/api/v10/users/@me";
    $options = array(
            'http' => array(
            'method' => 'GET',
            'header' => "Authorization: Bearer " . $accessToken
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result, true);
    //var_dump($result);
    echo "Hello {$result['username']}";
}

    /*========= PROVIDER GOOGLE =========*/
    function gocallback()
    {
        $specifParams = [
            "grant_type" => "authorization_code",
            "code" => $_GET["code"]
        ];

        $clientId = "727904560873-1im2ajo9g79bp0tugf7nad4t2pvpkrfs.apps.googleusercontent.com";
        $clientSecret = "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";
        $redirectUri = "http://localhost:8081/go_callback";

        $data = http_build_query(array_merge([
            "redirect_uri" => $redirectUri,
            "client_id" => $clientId,
            "client_secret" => $clientSecret,
        ], $specifParams));

        $url = "https://oauth2.googleapis.com/token";
        $options = array(
            'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded",
            'content' => $data
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        $accessToken = $result['access_token'];

        $url = "https://www.googleapis.com/oauth2/v1/userinfo";
        $options = array(
                'http' => array(
                'method' => 'GET',
                'header' => 'Authorization: Bearer ' . $accessToken
            )
        );

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $result = json_decode($result, true);
        //var_dump($result);
        echo "Hello {$result['name']}";
    }

$route = $_SERVER['REQUEST_URI'];
switch (strtok($route, "?")) {
    case '/login':
        login();
        break;
    case '/callback':
        callback();
        break;
    case '/fb_callback':
        fbcallback();
        break;
    case '/git_callback':
        gitcallback();
        break;
    case '/ds_callback':
        dscallback();
        break;
    case '/go_callback':
        gocallback();
        break;
    default:
        echo '404';
        break;
}


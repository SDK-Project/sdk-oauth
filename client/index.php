<?php
namespace App;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SDK - OAUTH</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php

use InvalidArgumentException;

require __DIR__ . DIRECTORY_SEPARATOR . 'conf.inc.php';

function myAutoloader($class)
{
    $class = str_ireplace('App\\', '', $class); // On supprime "App\" de App\providers\Facebook
    $class = str_ireplace('\\', '/', $class); // providers/Facebook
    $class .= '.class.php';
    if(!file_exists($class)){
        throw new InvalidArgumentException("Invalid file");
    }
    include $class; //Include car on a déjà vérifier son existance
}
spl_autoload_register('App\myAutoloader');

function home()
{
    echo "<div class='seco'><a href=\"/login\" class='btn-login'>Navigation vers SDK OAUTH</a></div>";
}

function login()
{
    $serv = new providers\Serv(CLIENT_ID_SERV, CLIENT_SECRET_SERV, REDIRECT_URI_SERV, 'read,write');
    $facebook = new providers\Facebook(CLIENT_ID_FB, CLIENT_SECRET_FB, REDIRECT_URI_FB, 'public_profile,email');
    $github = new providers\Github(CLIENT_ID_GIT, CLIENT_SECRET_GIT, REDIRECT_URI_GIT, 'user', [], 'github');
    $discord = new providers\Discord(CLIENT_ID_DS, CLIENT_SECRET_DS, REDIRECT_URI_DS, 'connections');
    $google = new providers\Google(CLIENT_ID_GO, CLIENT_SECRET_GO, REDIRECT_URI_GO, 'profile');


    echo "
        <form action='callback' method='POST' id='login-form'>
            <div class='heading'>SDK OAUTH</div>
            <div class='left'> 
                <label for='username'>Nom d'utilisateur</label> <br>           
                <input type='text' name='username'> <br>
                <label for='password'>Mot de passe</label> <br>
                <input type='text' name='password'> <br>
                <input type='submit' value='Connexion'>
            </div>
            <div class='right'>
                <div class='connect'>Se connecter avec :</div>
                <a href={$serv->getAuthUrl()} class='btn'>
                    SERV
                </a> <br>
                <a href={$facebook->getAuthUrl()} class='btn'>
                    FACEBOOK
                </a> <br>
                <a href={$github->getAuthUrl()} class='btn'>
                    GITHUB
                </a> <br>
                <a href={$discord->getAuthUrl()} class='btn'>
                    DISCORD
                </a> <br>
                <a href={$google->getAuthUrl()} class='btn'>
                    GOOGLE
                </a> <br>
            </div>
        </form>
    ";
}

/*========= PROVIDER SERV =========*/
function callback()
{
    $serv = new providers\Serv(CLIENT_ID_SERV, CLIENT_SECRET_SERV, REDIRECT_URI_SERV, 'read,write');
    echo "<p>Bienvenue ".$serv->getUser($serv->getAccessToken(empty($_GET['code']) ? $_GET['code'] = 'test' : $_GET['code']))."</p>";
}

/*========= PROVIDER FACEBOOK =========*/
function fbcallback()
{
    $facebook = new providers\Facebook(CLIENT_ID_FB, CLIENT_SECRET_FB, REDIRECT_URI_FB, 'public_profile,email');
    echo "<p>Bienvenue ".$facebook->getUser($facebook->getAccessToken($_GET['code']))."</p>";
}

/*========= PROVIDER GITHUB =========*/
function gitcallback()
{
    $github = new providers\Github(CLIENT_ID_GIT, CLIENT_SECRET_GIT, REDIRECT_URI_GIT, 'user', [], 'github');
    echo "<p>Bienvenue ".$github->getUser($github->getAccessToken($_GET['code']))."</p>";
}


/*========= PROVIDER DISCORD =========*/
function dscallback()
{
    $discord = new providers\Discord(CLIENT_ID_DS, CLIENT_SECRET_DS, REDIRECT_URI_DS, 'connections'); 
    echo "<p>Bienvenue ".$discord->getUser($discord->getAccessToken($_GET['code']))."</p>";
}

/*========= PROVIDER GOOGLE =========*/
function gocallback()
{
    $google = new providers\Google(CLIENT_ID_GO, CLIENT_SECRET_GO, REDIRECT_URI_GO, 'profile');
    echo "<p>Bienvenue ".$google->getUser($google->getAccessToken($_GET['code']))."</p>";
}

$route = $_SERVER['REQUEST_URI'];
switch (strtok($route, "?")) {
    case '/':
        home();
        break;
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
?>

</body>
</html>
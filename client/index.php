<?php

namespace App;

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
    echo "<a href=\"/login\">Se connecter</a>";
}

function login()
{

    echo "
        <form action='callback' method='POST'>
            <input type='text' name='username'>
            <input type='text' name='password'>
            <input type='submit' value='Login'>
        </form>
    ";

    $serv = new providers\Serv(CLIENT_ID_SERV, CLIENT_SECRET_SERV, REDIRECT_URI_SERV, 'read,write');
    echo "<a href={$serv->getAuthUrl()}>Se connecter via Oauth Server</a><br>";

    $facebook = new providers\Facebook(CLIENT_ID_FB, CLIENT_SECRET_FB, REDIRECT_URI_FB, 'public_profile,email');
    echo "<a href={$facebook->getAuthUrl()}>Se connecter via Facebook</a><br>";

    $github = new providers\Github(CLIENT_ID_GIT, CLIENT_SECRET_GIT, REDIRECT_URI_GIT, 'user', [], 'github');
    echo "<a href={$github->getAuthUrl()}>Se connecter via Github</a><br>";

    $discord = new providers\Discord(CLIENT_ID_DS, CLIENT_SECRET_DS, REDIRECT_URI_DS, 'connections');
    echo "<a href={$discord->getAuthUrl()}>Se connecter via Discord</a><br>";

    $google = new providers\Google(CLIENT_ID_GO, CLIENT_SECRET_GO, REDIRECT_URI_GO, 'profile');
    echo "<a href={$google->getAuthUrl()}>Se connecter via Google</a><br>";    
}

/*========= PROVIDER SERV =========*/
function callback()
{
    $serv = new providers\Serv(CLIENT_ID_SERV, CLIENT_SECRET_SERV, REDIRECT_URI_SERV, 'read,write');
    echo $serv->getUser($serv->getAccessToken(empty($_GET['code']) ? $_GET['code'] = 'test' : $_GET['code']));
}

/*========= PROVIDER FACEBOOK =========*/
function fbcallback()
{
    $facebook = new providers\Facebook(CLIENT_ID_FB, CLIENT_SECRET_FB, REDIRECT_URI_FB, 'public_profile,email');
    echo $facebook->getUser($facebook->getAccessToken($_GET['code']));
}

/*========= PROVIDER GITHUB =========*/
function gitcallback()
{
    $github = new providers\Github(CLIENT_ID_GIT, CLIENT_SECRET_GIT, REDIRECT_URI_GIT, 'user', [], 'github');
    echo $github->getUser($github->getAccessToken($_GET['code']));
}


/*========= PROVIDER DISCORD =========*/
function dscallback()
{
    $discord = new providers\Discord(CLIENT_ID_DS, CLIENT_SECRET_DS, REDIRECT_URI_DS, 'connections');
    echo $discord->getUser($discord->getAccessToken($_GET['code']));   
}

/*========= PROVIDER GOOGLE =========*/
function gocallback()
{
    $google = new providers\Google(CLIENT_ID_GO, CLIENT_SECRET_GO, REDIRECT_URI_GO, 'profile');
    echo $google->getUser($google->getAccessToken($_GET['code']));
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
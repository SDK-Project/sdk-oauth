<?php

namespace App;

require __DIR__ . DIRECTORY_SEPARATOR . 'conf.inc.php';

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
    
}

/*========= PROVIDER SERV =========*/
function callback()
{
    
}

/*========= PROVIDER FACEBOOK =========*/
function fbcallback()
{
    
}

/*========= PROVIDER GITHUB =========*/
function gitcallback()
{
   
}


/*========= PROVIDER DISCORD =========*/
function dscallback()
{
    
}

/*========= PROVIDER GOOGLE =========*/
function gocallback()
{
   
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
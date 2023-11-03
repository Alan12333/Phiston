<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 86400);
session_start();
include("App/core/__App/bin/Views.php");
include("App/core/__App/bin/integrations.php");
include("App/core/__App/bin/__Athorization/Auth.php");
include("App/core/__App/bin/App.php");


Init();

function Init()
{
    CreateToken();
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    //Configuracion extraida desde el archivo config.json
    switch($products["production"])
    {
        case false:
            error_reporting(E_ALL);
            ini_set('display_errors', '1'); 
            break;
        case true:
            error_reporting(E_ALL);
            ini_set('display_errors', '0'); 
            break;
    }
        
} 

function CreateToken()
{
    if(isset($_SESSION['token']) == false)
    {
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        setcookie("Session", $_SESSION['token'], time()*2);
    }
}

?>
<?php

function Call($action,$controller)
{
    $url='controllers/'.$controller.'_controller.php';
    require_once($url);
    if($controller=='Page')
    {
        $calssname= $controller.'_Controller';
        $controller= new $calssname;
    }
    
    else
    {
        require_once("Views/app/error.php");
    }
    $controller->{ $action}();
}

$controllers=array(
    'Page'=>['index', 'error404', 'error403', 'error500', 'Tooling','Servicios','PI','PI2']
);

if(array_key_exists($controller, $controllers))
{
    if(in_array($action,$controllers[$controller]))
    {
        Call($action,$controller);
    }
    else
    {
        Call("error404",$controller);
    }
}
else
{
    Call("error404",$controller);
}


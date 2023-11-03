<?php 
include dirname(__FILE__)."/blocks.php";
include dirname(__FILE__,4)."/pages.php";
include dirname(__FILE__)."/Folder/DisplayErrors.php";
include dirname(__FILE__,2)."/__DB/DB.php";
$block = new Blocks($controller,$action);
Inits($controller, $blocks, $action, $block,);


function Inits($controller, $blocks, $action, $block)
{
    if(array_key_exists($controller, $blocks))
    {
        if($controller!="")
        {
            if(in_array($action,$blocks[$controller]))
            {
                $block->Call();
            }
            else
            {
                if($block->display==true)
                {
                    PrintErrors::PrintScreenError("No existe el método dentro del Controlador " . $controller,"203");
                }
                else
                {
                    http_response_code(404);
                    require_once  dirname(__FILE__)."/Folder/Views/404.php";
                }
            }
        }
    }
    else
    {
        if($block->display==true)
        {
            PrintErrors::PrintScreenError("No existe el bloque del controlador principal", "201");
        }
        else
        {
            http_response_code(404);
            require_once  dirname(__FILE__)."/Folder/Views/404.php";
        }
        
    }
}
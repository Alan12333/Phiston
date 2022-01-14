<?php

class Config
{
    public $controller;
    public $action;

    public function Index($page_principal)
    {
        $action ="";
        $controller="";
        if(isset($_GET['action']))
        {
            $rutas=explode("/",$_GET['action']);
            $this->SelectVIew($rutas, $page_principal);
        }
        else
        {
            $this->LoadDefaultView($page_principal);
        }
        $action =$this->action;
        $controller=$this->controller;
        require_once("routes.php");
    }

    private function CountArray($array)
    {
        $cont=0;
        for ($i=0; $i < count($array); $i++) { 
            $cont++;
        }
        
        return $cont;
    }

    private function SelectVIew($array, $page_principal)
    {
        $cont = $this->CountArray($array);
        if($cont==2)
        {
            
            $this->controller = $array[0];
            $this->action = 'index';
        }
        else if($cont<2)
        {
            $this->controller = $page_principal;
            $this->action = $array[0];
        }
        else if($cont>2)
        {
            $this->controller = $array[0];
            $this->action = $array[1];
        }
    }

    private function LoadDefaultView($page_principal)
    {
        $this->controller = $page_principal;
        $this->action="index";
    }
}


?>
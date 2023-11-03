<?php
include (dirname(__FILE__,4)."/Layouts/index.php");
include (dirname(__FILE__,)."/_Model/Model.php");
require_once(dirname(__FILE__,4)."/core/__Rols/Rols.php");
class App
{
    public $controller;
    public $action;

    public function Index(string $page_principal="Page")
    {
        $action ="";
        $controller="";
        if(isset($_GET['action']))
        {
            $rutas=explode("/",$_GET['action']);
            $neform = str_split($_GET['action']);
            $this->SelectVIew($rutas, $page_principal, $neform);
        }
        else
        {
            $this->LoadDefaultView($page_principal);
        }
        $action =$this->action;
        $controller=$this->controller;
        require_once("App/core/__Blocks/index.php");
    }

    private function CountArray($array)
    {
        $cont=0;
        for ($i=0; $i < count($array); $i++) { 
            if($array[$i]=="")
            {
                
            }
            else
            {
                $cont++;
            }
        }
        
        return $cont;
    }
    private function CountSeparator($second)
    {
        
        $cont =0;
        for($i=0; $i<count($second); $i++)
        {
            if($second[$i]=="/")
            {
                $cont ++;
            }
        }
        
        return $cont;
    }
    private function SelectVIew($array, $page_principal, $second)
    {
        $cont = $this->CountSeparator($second);
        $cont2 = $this->CountArray($array);
        if($cont ==2 && $cont2==2 && $cont<3 && $cont2<3 || $cont == 1 && $cont2 == 2)
        {
            $this->controller = $array[0];
            $this->action = $array[1];
        }
        else if($cont==0 && $cont2==0 || ($cont==0 && $cont2==1) )
        {
            $this->controller = $page_principal;
            $this->action = $array[0];
        }
        else
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
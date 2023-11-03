<?php

class Blocks
{
    public $controller = "";
    public $action = "";
    public $display = "";
    function __construct($controller, $action)
    {
        $this->DisplayErrors();
        $this->controller=$controller;
        $this->action=$action;
    }
    function Call()
    {
        $url='App/controllers/'.$this->controller.'_Controller.php';
        $urls = scandir("App/controllers");
        $validacion = false;
        foreach ($urls as $key => $value) {
            if($this->controller.'_Controller.php'==$value)
            {
                $validacion=true;
            }
        }
        if($validacion==true)
        {
            require_once($url);
            $this->action = $this->SpecialCase();
            $classname= $this->controller.'_Controller';
            $newclass = new $classname;
            if(method_exists($newclass, $this->action))
            {
                $data = $newclass->{ $this->action}();
            
                if(is_object($data) == true || is_array($data)==true)
                {
                    header("Content-Type:application/json");
                    header('Access-Control-Allow-Origin: *');
                    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
                    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
                    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
                    echo json_encode($data);
                }
            }
            else
            {
                if($this->display==true)
                {
                    echo "No existe el metodo en la clase ".$this->controller;
                }
                else
                {
                    require_once  dirname(__FILE__)."/Folder/Views/404.php";
                }
            }
        }
        else
        {
            if($this->display==true)
            {
                echo "No existe el controlador ni la clase ".$this->controller;
            }
            else
            {
                require_once  dirname(__FILE__)."/Folder/Views/404.php";
            }
        }
        
    }

    private function SpecialCase()
    {
        $string = $this->action;
        $expl = explode("-", $string);
        $cont = count($expl);
        $newstring="";
        
        if($cont>=2)
        {
            for($i=0; $i<$cont; $i++)
            {
                if($i==0)
                {
                    $newstring=$expl[$i];
                }
                else if($i==$cont-1)
                {
                    $newstring = $newstring."_".$expl[$i];
                }
                else
                {
                    $newstring = $newstring."_".$expl[$i]."_";
                }   
            }
        }
        else
        {
            $newstring = $this->action;
        }
        return $newstring;
    }
    private function DisplayErrors()
    {
        $data = file_get_contents("config.json");
        $products = json_decode($data, true);
        if($products['production']==true)
        {
            $this->display=true;
        }
        else
        {
            $this->display=false;
        }
    }
}



?>

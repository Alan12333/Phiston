<?php 

function import($module="")
{
    require_once("App/core/__".$module."/".$module.".php");
}

function ImportBlock($rute="")
{
    $controllersPath = dirname(__DIR__,4). "/App/controllers/";
    $controllers = scandir($controllersPath);
    foreach($controllers as $item) {
        if ($item !== "." && $item !== "..") {
            require_once($controllersPath . $item);
        }
    }
    $array = explode("/", $rute);
    if(count($array) > 1)
    {
        $files = $array[1];
        require_once ("App/Views/".$rute."/$files.block.php");
    }
    else
    {
        require_once ("App/Views/".$rute."/$name.block.php");
    }
} 


function Location($route="")
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    header("Location:".$products['route']."/".$products['ProjectName']."/".$route);
    die();
}

function importModel($model)
{
    require_once ("App/Models/".$model.".php");
}

function CSRF($inter="")
{
    ?>
        <input type="hidden" name="token" id="token" value="<?php echo $_SESSION['token']?>">
    <?php
}
function CSRFVal()
{
    echo $_SESSION['token'];
}
function Image($src)
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    echo $products['route']."/".$products['ProjectName']."/App/public/img/".$src;  
}
function Icon($src)
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    echo $products['route']."/".$products['ProjectName']."/App/public/icon/".$src;    
}
function action($view)
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    $route = $products['route']."/".$products['ProjectName']."/".$view;
    return $route;
}

function VerifyMethod($data="")
{
    if(isset($_POST[$data]))
    {
        return true;
    }
    else
    {
        return false;
    }
}
function WIN($data="")
{
    return $_POST[$data];
}

function ImportBCSS($name)
{
    $rutas = explode(".", $name);
    if(isset($rutas[1]))
    {
        $data = file_get_contents("config.json");
        $rute = json_decode($data, true);
        ?> <link rel="stylesheet" href="<?php echo $rute['route'].'/'.$rute['ProjectName'].'/App/Views/'.$rutas[0].'/'.$rutas[1]."/".$rutas[1].'.style.css'?>"> <?php
    }
    else
    {
        $data = file_get_contents("config.json");
        $rute = json_decode($data, true);
        ?> <link rel="stylesheet" href="<?php echo $rute['route'].'/'.$rute['ProjectName'].'/App/Views/'.$name.'/'.$name.'.style.css'?>"> <?php
    }
}

function include_dep($name="")
{
    $check = explode(".",$name);
    $data = file_get_contents("config.json");
    $rute = json_decode($data, true);
    if($check[count($check) - 1] == "css")
    {

        echo "\n\t\t\t<link rel='stylesheet' href='".$rute['route']."/".$rute['ProjectName']."/App/public/dep/css/".$name."'>";
        
    }
    else
    {
        echo "\n\t\t\t<script src='".$rute['route']."/".$rute['ProjectName']."/App/public/dep/js/".$name."'></script>";
    }
    
}

function ext_css($url)
{
    echo "\n\t\t\t$url";
}

function ext_js($url)
{
    echo "\n\t\t\t$url";
}


function view()
{
    require_once('App/Views/app/index.php');
}

function Layout($name="",$param="")
{
    $param = $param;
    Layouts::$layoutname = $name;
    require_once (dirname(__FILE__,4)."/Layouts/templates/".Layouts::LoadLayouts());
}

function getvalue($value)
{
    if(isset($_POST[$value]))
    {
        if($_POST[$value] === "")
        {
            echo "el valor de ".$value." es nulo";
        }
        else
        {
            $valor = $_POST[$value];
            $db = DB::Instance();
            $scape = mysqli_real_escape_string($db->Connection(), $valor);
            return $scape;
        }
    } 
}
function to($module="", $params=[])
{
    if(count($params) === 0)
    {
        $data = file_get_contents("config.json");
        $rute = json_decode($data, true);
        $url2 = $rute['route']."/".$rute['ProjectName']."/".$module;
        echo $url2;
    }
    else
    {
        $data = file_get_contents("config.json");
        $rute = json_decode($data, true);
        $url2 = $rute['route']."/".$rute['ProjectName']."/".$module;
        $url3="";
        foreach($params as $key => $values)
        {
            $url3 .= "/".$key."/".$values;
        
        }
        $to = $url2.$url3;
        echo $to;
    }
}
function redirect($url)
{
    $data = file_get_contents("config.json");
    $rute = json_decode($data, true);
    $url2 = $rute['route']."/".$rute['ProjectName']."/".$url;
    $headers = get_headers($url2);
    if (strpos($headers[0], '200') !== false) {
        header("location: $url2");
        echo $url2;
    } else {
        echo "Location not exists.";
    }
}

function getarray($value)
{
    $array = array();
    $valor =  json_decode($_POST[$value], true);
    if(is_array($valor)==true)
    {
        $data = json_encode($valor);
        $array = json_decode($data);
        return $array;
    }
}

function styles()
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    $directorio = 'App/public/css';
    $ficheros1  = scandir($directorio);
    for($i=2; $i<count($ficheros1); $i++)
    {
        echo "\n\t\t\t<link rel='stylesheet' href='".$products['route']."/".$products['ProjectName']."/App/public/css/".$ficheros1[$i]."'>";
    }
}

function import_helper($name)
{
    require_once ("App/helpers/".$name.".php");
}



function scripts($exclude=[])
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    $directorio = 'App/public/js';
    $ficheros1  = scandir($directorio);
    if(count($exclude) === 0)
    {
        for($i=2; $i<count($ficheros1); $i++)
        {
            if($ficheros1[$i]!="render.php")
            {
                echo "<script src='".$products['route']."/".$products['ProjectName']."/App/public/js/".$ficheros1[$i]."'></script>\n";
            }
        }
    }
    else
    {
        for($i=0; $i < count($exclude); $i++)
        {
            for($j=2; $j<count($ficheros1); $j++)
            {
                if($ficheros1[$j] != "render.php")
                {
                    if($exclude[$i] != $ficheros1[$j])
                    {
                        echo "<script src='".$products['route']."/".$products['ProjectName']."/App/public/js/".$ficheros1[$j]."'></script>\n";
                    }
                }
            }
        }
    }
}
<?php
include (dirname(__FILE__,)."/Minifier.php");
class Render
{
    private static $name;
    private static $ruta;

    private static function GetModule($folder, $file, $type)
    {
        self::$name = $file;
        $data = file_get_contents("../../../config.json");
        $products = json_decode($data, true);
        if($type === "js")
        {
            $ruta  = $products['route']."/".$products['ProjectName']."/App/Views/".$folder."/".$file.".script.js"; 
            
        }
        else{
            $ruta  = $products['route']."/".$products['ProjectName']."/App/Views/".$folder."/".$file.".style.css";  
            
        }
        self::$ruta = $ruta;
    }

    private static function CheckFile()
    {
        $headers = get_headers(self::$ruta);

        if ($headers && strpos($headers[0], '200') !== false) {
            return true;
        } else {
            return false;
        }
    }

    public static function TransformCss($folder, $file)
    {
        self::GetModule($folder, $file, "css");
        
        if(self::CheckFile())
        {
            $contenidoCSS = file_get_contents(self::$ruta);
            echo Minifier::minify($contenidoCSS, array('flaggedComments' => false));
        }
        else
        {
            echo "File not exist";
        }
    }

    public static function TransformjS($folder,$file)
    {
        self::GetModule($folder, $file, "js");
        if(self::CheckFile())
        {
            header("Content-Type: text/javascript");
            $contenidoJS = file_get_contents(self::$ruta);
            echo Minifier::minify($contenidoJS, array('flaggedComments' => false));
        }
        else
        {
            echo "File not exist";
        }
    }
}

?>
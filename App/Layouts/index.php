<?php
class Layouts
{
    public static $layoutname = "";

    public function __construct()
    {

    }

    public static function LoadLayouts()
    {
        if(Layouts::$layoutname=="")
        {
            echo "No puede estar vacia la cadena de layout";
        }
        else
        {
            $urls = scandir(dirname(__FILE__,1)."/templates");
            foreach ($urls as $key => $value) {
                $cadena = explode("..",$value);
                $cadena2 = explode(".",$cadena[0]);
                if($cadena2[0]==Layouts::$layoutname)
                {
                    return $cadena[0];
                }
                else
                {
                    echo false;
                }
            }
        }
    }
}
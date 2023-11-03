<?php
/**
 * HTML to Mail
 * 
 * @Descripción: Librería para transformar y maquetar un HTM y sea compatible con los clientes de correo electrónico
 * @author Alan Guzman
 * @version 1.0
 * @mail alan.guzman12333@gmail.com
 */
require_once (__DIR__)."/src/AddRenders.php";
require_once (__DIR__)."/src/Structures.php";
class HTMLMAIL
{
    protected static $render;
    protected static $struct;

    private static function Init()
    {
        if (!isset(self::$render)) {
            self::$render = new AddRenders;
        }
    }

    private static function InitStructure()
    {
        if (!isset(self::$struct)) {
            self::$struct = new Structures;
        }
    }

    public static function Render($function=null, $styles_url="")
    {
        self::Init();
        $body = self::$render->CreateBody($function, $styles_url);
        return $body;
    }

    public static function getheaders($from="")
    {
        if($from === "")
        {
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            return $headers;
        }
        else
        {
            $headers = "From:".$from."\r\n";
            $headers .= "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            return $headers;
        }
    }

    public static function AddBlock($function = null, $styles="")
    {
        self::Init();
        return self::$render->CreateBlock($function, $styles);
    }

    public static function AddTitle($title = "", $styles="")
    {
        self::Init();
        return self::$render->CreateTitle($title, $styles);
    }

    public static function LinkImage($url="", $url_image="", $width="", $styles="")
    {
        self::Init();
        return self::$render->LinkImage($url, $url_image, $width, $styles);
    }

    public static function AddParagraph($text = "", $styles="")
    {
        self::Init();
        return self::$render->CreateParr($text, $styles);
    }
    public static function AddText($text = "", $styles="")
    {
        self::Init();
        return self::$render->CreateText($text, $styles);
    }

    public static function Column($function, $styles="")
    {
        self::Init();
        return self::$render->CreateColumn($function, $styles);
    }

    public static function AddButton($text="",$url="", $styles="")
    {
        self::Init();
        return self::$render->CreateButton($text,$url, $styles);
    }

    public static function AddImage($url="", $width="", $hei="", $style="")
    {
        self::Init();
        return self::$render->CreateImage($url, $width, $hei, $style);
    }

    public static function AddRow($function=null, $style="")
    {
        self::Init();
        return self::$render->CreateRow($function, $style);
    }

    public static function AddHeader($function = null, $styles="")
    {
        self::Init();
        return self::$render->AddHeaders($function, $styles);
    }

    public static function ForIn($array, $function)
    {
        $function_html = htmlspecialchars($function);
        $patron = "/{item\.\w+}/";
        $contitems_array = "";
        if (preg_match($patron, $function, $matches)) {
            $itemNombre = $matches[0];
            $contitems_array = explode($itemNombre, $function_html);
        }
        $cont_items = explode("{item}", $function_html);
        $cont_index = explode("{index}", $function_html);
        self::InitStructure();
        $varreturn = "";
        if(count($cont_items) >= 2 || count($contitems_array)>=2)
        {
            $cont = 0;
            foreach ($array as $item) {
                $varreturn .= self::$struct->reemplazar($function_html, $item, $cont);
                $cont++;
            }
        }
        else if(count($cont_index) >= 2)
        {
            $cont = 0;
            foreach ($array as $item) {
                $varreturn .= self::$struct->reemplazar($function_html, $item="", $cont);
                $cont++;
            }
        }
        else
        {
            foreach ($array as $item) {
                $varreturn .= $function();
                
            }
        }
        return $varreturn;
    }


}

?>
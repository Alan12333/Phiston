<?php
/**
 * Imgstick Exception class.
 * PHP Version 8.0.
 *
 * @see       https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 *
 * @author    Alan Guzman  <alan.guzman@baniradigital.com>
 * @copyright 2021 - 2023 baniradigital
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */


class Transform
{
    /**
     * Variable para mostrar el mensaje
     *
     * @var string
     */
    private static $message;


    /**
     * variable para la imagen
     *
     * @var string
     */
    private static $imagen;


    /**
     * Funcion para transformar los diferentes tipos de imagen
     *
     * @var string
     *
     * @return string
     */

    public static function Transform($image="", $imagetype = "webp", $type="png", $rute="", $quality=80)
    {
        
        if($image === "")
        {
            return self::exception(); 
        }
        else
        {
            self::$imagen = $image;
            $choice = self::Choice($imagetype);
            if($choice)
            {
                return self::Create($choice,$rute,$type,$quality);
            }
        }
    }

    /**
     * Funcion para escoger el tipo de transfromacion
     * 
     * @var string
     * 
     * @return GdImage|boolean
     *  
     */
    private static function Choice($type)
    {
        switch($type)
        {
            case "png":
                return self::TransformToPNG();
                break;
            case "jpg":
                return self::TransformToJPG();
                break;
            case "jpeg":
                return self::TransformToJPG();
                break;
            case "gif":
                return self::TransformToGIF();
                break;
            case "webp":
                return self::TransformToWEBP();
                break;
        }
    }

    /**
     * Funciones para crear a los formates pertenecientes
     * 
     */

    private static function TransformToPNG()
    {
        $image = imagecreatefrompng(self::$imagen);
        imagepalettetotruecolor($image);
        return $image;
    }

    private static function TransformToJPG()
    {
        $image = imagecreatefromjpeg(self::$imagen);
        imagepalettetotruecolor($image);
        return $image;
    }

    private static function TransformToWEBP()
    {
        $image = imagecreatefromwebp(self::$imagen);
        imagepalettetotruecolor($image);
        return $image;
    }

    private static function TransformToGIF()
    {
        $image = imagecreatefromgif(self::$imagen);
        imagepalettetotruecolor($image);
        return $image;
    }


    /**
     * Mensaje de cadena vacia para las imagenes
     * 
     * @return string
     */
    private static function Exception()
    {
        return self::$message = "Error Imge is empty";
    }


    /**
     * Esta funcion se encarga de crear la imagen dependiendo del tipo de extension
     * 
     * @return boolean
     */

    private static function Create($image, $rute, $type, $quality)
    {
        switch($type)
        {
            case "png":
                $newrute = $rute."/".self::GetRute($type);
                imagepng($image,$newrute,9);
                return self::CreateResponse($newrute,self::GetRute($type));
                break;
            case "jpg":
                $newrute = $rute."/".self::GetRute($type);
                imagejpeg($image, $newrute, $quality);
                return self::CreateResponse($newrute,self::GetRute($type));
                break;
            case "jpeg":
                $newrute = $rute."/".self::GetRute($type);
                imagejpeg($image, $newrute, $quality);
                return self::CreateResponse($newrute,self::GetRute($type));
                break;
            case "gif":
                $newrute = $rute."/".self::GetRute($type);
                imagegif($image,$newrute);
                return self::CreateResponse($newrute,self::GetRute($type));
                break;
            case "webp":
                $newrute = $rute."/".self::GetRute($type);
                imagewebp($image, $newrute, $quality);
                return self::CreateResponse($newrute,self::GetRute($type));
                break;
        }
    }

    private static function GetRute($type)
    {
        switch($type)
        {
            case "png":
                return self::RandomString().".png";
                break;
            case "jpg":
                return self::RandomString().".jpg";
                break;
            case "jpeg":
                return self::RandomString().".jpg";
                break;
            case "gif":
                return self::RandomString().".gif";
                break;
            case "webp":
                return self::RandomString().".webp";
                break;
        }
    }


    /**
     * Metodo para generar una cadena aleatoria de caracteres de n tamaño
     *
     * @var int
     *
     * @return string
     * 
     */

    private static function RandomString($longitud=15)
    {
        $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomstring = "";
        for($i=0; $i<$longitud; $i++)
        {
            $index = rand(0,strlen($char) -1 );
            $randomstring .= $char[$index];
        }
        return $randomstring;
    }

    private static function CreateResponse($rute, $name)
    {
        $size = filesize($rute); 
        $json = array(
            "image_url"=>$rute,
            "name"=>$name,
            "size"=>$size
        );
        $data = json_encode($json);
        return $data;
    }
}
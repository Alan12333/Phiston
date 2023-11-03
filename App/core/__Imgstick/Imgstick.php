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



include dirname(__FILE__).'/src/Types.php';
include dirname(__FILE__).'/src/Transform.php';


class ImgStick
{
    /**
     * Tipo de entrada de conversion
     * @var string
     */
    private static $type;


    /**
     * Ruta del Archivo por defecto es a Resources Img
     * 
     * @var string
     */
    private static $rute = "App/Resources/Img";

    /**
     * Imagen cargada desde php
     * 
     * @var string
     */
    private static $image="";

    /**
     * Calidad en la imagen
     * 
     * @var int
     */
    private static $quality = 80;


    private static function Define($imagen, $transform_type, $rute, $quality)
    {
        if($imagen==="")
        {
            return false;
        }
        else
        {
            self::$image = $imagen;
        }
        if($transform_type != "" || $rute != "" || $quality != "")
        {
            self::$rute = $rute;
            self::$quality=$quality;
            self::$type = $transform_type;
        }
    }

    public static function ConvertImage($imagen, $transform_type, $rute, $quality)
    {
        self::Define($imagen, $transform_type,$rute,$quality);
        echo Types::TransformImage(self::$image, self::$type,self::$quality,self::$rute);
    }
}
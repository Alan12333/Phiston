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


class Types
{
    /**
     * variable de la ruta de imagenes
     * @var string
     *
     */
    private static $rute;

    /**
     * Variable del tipo de imagen
     * @var string
     */
    private static $imagetype;

    /**
     * Variable del tipo de conversion
     * @var  string
     */
    private static $convert;

    /**
     * Variable de tipo entera para la opcion de calidad de la imagen
     * @var int
     */
    private static $quality;

    /**
     * Variable de la imagen
     * 
     * @string
     */
    private static $imagen;


    private static function Declare($img=null, $convert_to="jpg",$quality=80,$rute="App/Resources/")
    {
        self::$imagen = $img;
        self::$convert = $convert_to;
        self::$rute=$rute;
        self::$quality = $quality;
    }


    /**
     * Funcion para validar el tipo de extension
     * 
     * @return boolean
     */

    private static function ValidateType()
    {
        return self::$imagetype === "gif" || self::$imagetype === "png" || 
        self::$imagetype === "jpeg" || self::$imagetype === "jpg"  || self::$imagetype === "webp" 
        ? true : false;
    }


    /**
     * Funcion para validar el rango de la calidad
     * 
     * @return boolean
     */

    private static function QualityCheck()
    {
        return self::$quality >= 1 && self::$quality <= 100 ? true : false;
    }


    /**
     * Funcion para validar la imagen existente
     * 
     * @return boolean
     */

    
    private static function ValidateImage()
    {
        return self::$imagen !="" ? true : false;
    }

    /**
     * Funcion para convertir la imagen la imagen
     * 
     * @return bool
     */

    public static function TransformImage($img=null, $convert_to="jpg",$quality=80,$rute="App/Resources/")
    {
        self::Declare($img,$convert_to,$quality,$rute);
        if(self::ValidateImage())
        {
            if(isset(self::$imagen['name']))
            {
                self::$imagetype = pathinfo(self::$imagen['name'],PATHINFO_EXTENSION);
                if(self::ValidateType())
                {
                    return Transform::Transform(self::$imagen['tmp_name'], self::$imagetype, self::$convert, self::$rute, self::$quality);
                }
            }
            else
            {
                if(self::ValidateType())
                {
                    return Transform::Transform(self::$imagen, self::$imagetype, self::$convert, self::$rute, self::$quality);
                }
            }
        }
        
    }
}


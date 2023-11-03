<?php
require_once dirname(__FILE__)."/src/FileUpload.php";
/**
 * 
 * ******************************************************************
 * Title: Files  2023
 * 
 * Description: Clase para la manipulacion de archivos en php.
 * 
 * Version: 1.0.1
 * autor: Alan Guzmán
 * mail: alan.guzman12333@gmail.com
 * 
 * *******************************************************************
 */

class Files
{
    

    /**
     * 
     * UploadFile se introduce en esta clase para el control de subida de archivos
     * 
     * @return string[]
     * 
     */
    public static function UploadFile($file="",$rute="",$options=[],$random_name=false)
    {
        $filesupload = new FilesUpload;
        return $filesupload->UploadFile($file,$rute,$options,$random_name);
    }

    /**
     * 
     * DeleteFile se introduce en esta clase para el control de eliminación de archivos
     * 
     * @return string[]
     * 
     */

    public static function DeleteFile($file)
    {
        $filesupload = new FilesUpload;
        return $filesupload->DeleteFile($file);
    }

    public static function SetFile($name)
    {
        if(isset($_FILES[$name]))
        {
            return $_FILES[$name];
        }
        else
        {
            return "No hay coincidencias";
        }
    }
}


?>
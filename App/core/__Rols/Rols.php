<?php 
require_once (dirname(__FILE__).'/src/Definitions.php');
/**
 * 
 * ******************************************************************
 * Title: Rols Class 2023
 * 
 * Description: Esta clase esta diseñada principalmente para el control de roles en una base de datos,
 * las bases de datos compatibles son: mysql
 * 
 * Version: 1.0.1
 * autor: Alan Guzmán
 * mail: alan.guzman12333@gmail.com
 * 
 * *******************************************************************
 */
class Rols extends Definitions
{
    /** 
     * Función para verificar el rol en alguna base de datos
     * 
     * @return callable||null
     * 
     */
    public static function  Check($module, $condition , $function=null)
    {
        try{
            //Comprueba que la condicion no sea nula
            if($condition != null)
            {
                //Ejecuta la condicion en la funcion Execute Condition de la clase Definitions si se cumple la condicion retorna la funcion anonima
                if(self::ExecuteCondition($condition)===true)
                {
                    return self::ReturnValues($module, $function);
                }
                else
                {
                    return self::ReturnValues($module, $condition);
                }
            }
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }

    public static function ShowRol()
    {
        try
        {
            return self::GetRol();
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }

    
    /**
     * 
     * Función para verificar si el usuario tiene acceso al contenido de la pagina o ruta 
     * a la que se intenta acceder
     * 
     * @return callable||Array 
     */

    public static function CheckPage($module , $array=["layout"=>"Pagina inaccesible contactar con soporte","time"=>2000,"url"=>""], $function=null, $condition=null)
    {
        try{
            if($array == NULL || $array == [])
            {
                $array=["layout"=>"Pagina inaccesible contactar con soporte","time"=>2000,"url"=>""];
            }
            if($condition !== null)
            {
                //Ejecuta la condicion en la funcion Execute Condition de la clase Definitions si se cumple la condicion retorna la funcion anonima
                if(self::ExecuteCondition($condition)===true)
                {
                    return self::Pagecheck($module, $function, $condition, $array);
                }
                else
                {
                    return self::Choice($array);
                }
            }
            else{
                return self::Pagecheck($module, $function, $condition, $array);
            }
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }
    
}


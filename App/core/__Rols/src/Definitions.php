<?php
include (dirname(__FILE__).'/Construct.php');

class Definitions 
{
    public static $id = "";

    public static function VerifyRol($module)
    {
        $cons = new Constructs($module);
        return $cons->Execute();
    }

    public static function ExecuteCondition($condition)
    {
        if($condition && !is_callable($condition))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public static function ReturnValues($module, $function)
    {
        if(is_array($module) != true)
        {
            if(self::VerifyRol($module) === true)
            {
                return $function($param="");
            }
        }
        else
        {
            foreach($module as $modul)
            {
                if(self::VerifyRol($modul) === true)
                {
                    return $function($param="");
                }
            }
        }
    }

    public static function GetRol()
    {
        $cons = new Constructs;
        return $cons->GetRol();
    }
}

?>
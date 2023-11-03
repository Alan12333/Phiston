<?php
include dirname(__FILE__).'/Contr/Contr.php';

use Contr\Contr;

Class Ses extends Contr
{
    public static function Show ($function)
    {
        if(isset($_SESSION['log'])===true)
        {
            echo $function();
        }
        else
        {
            echo "856";
        }
    }

    public static function PageAuth($array=["layout"=>"","time"=>0.20,"url"=>""], $function=null)
    {
        if(isset($_SESSION['log'])===true)
        {
            return $function();
        }
        else
        {
            if(isset($array) != null)
            {
                Contr::Choice($array);
            }
        }
    }
    public static function id()
    {
        return $_SESSION['id'];
    }

    public static function Token()
    {
        return $_SESSION['token'];
    }

    public static function Login($table = "", $optional_param="" , $action = null)
    {
        if($action != null)
        {
            echo $action($param="");
            return Contr::AccesLogin($table, $optional_param);
        }
        else
        {
            return Contr::AccesLogin($table, $optional_param);
        }
    }

    public static function CreateAtribute($atribute, $value)
    {
        if($value === "")
        {
            echo "Atribute is empty";
        }
        else
        {
            $_SESSION[$atribute] = $value;
            return $_SESSION[$atribute];
        }
    }

    public static function ShowAtribute($atribute)
    {
        if($atribute === "")
        {
            return null;
        }
        else
        {
            return $_SESSION[$atribute];
        }
    }

    public static function Exit($function = null)
    {
        session_unset();
        session_destroy();
        if($function != null)
        {
            return $function($param="");
        }
        else
        {
            redirect("./");
        }
    }

    public static function Active($sesion = "")
    {
        if(isset($_SESSION[$sesion]) || isset($_SESSION['log']))
        {
            if($sesion != "")
            {
                if($_SESSION[$sesion] === true)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                if($_SESSION['log'] === true)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }

    }
}
?>
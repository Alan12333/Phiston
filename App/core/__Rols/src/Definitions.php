<?php
include (dirname(__FILE__).'/Construct.php');
include (dirname(__FILE__).'/Exception.php');

class Definitions extends RolsException
{
    public static $id = "";

    function __construct()
    {
        self::setErrorHandler();
    }
    protected static function VerifyRol($module)
    {
        try{
            $cons = new Constructs($module);
            return $cons->Execute();
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }

    protected static function ExecuteCondition($condition)
    {
        try{
            if($condition && !is_callable($condition))
            {
                return true;
            }
            else
            {
                return false;
            }
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }

    protected static function ReturnValues($module, $function)
    {
        try{
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
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }

    protected static function Pagecheck($module, $function,$condition=null,  $array=[])
    {   
        try{
            if(is_array($module) != true)
            {
                if(self::VerifyRol($module) === true)
                {
                    return $function($param="");
                }
                else
                {
                    return self::Choice($array);
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
                    else
                    {
                        try{
                            return self::Choice($array);
                        } catch(Error $e){
                            return self::CreateAlert($e);
                        }
                    }
                }
            }
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }

    protected static function GetRol()
    {
        try{
            $cons = new Constructs;
            return $cons->GetRol();
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }

    protected static function Choice($array)
    {
        try{

            if(isset($array["layout"]) != "")
            {
                echo $array["layout"];
            }
            if(isset($array["time"]) != "")
            {
                if(isset($array['url']))
                {
                    if(isset($array['url'],) === "")
                    {
                        ?>
                            <script>
                                window.location="./";
                            </script>
                        <?php
                    }
                    else
                    {
                        ?>
                        <script>
                            setTimeout(() => {
                                window.location="<?php echo $array['url']?>";
                            }, <?php echo $array["time"]?>);
                        </script>
                    <?php  
                    }
                }
                else{
                    ?>
                        <script>
                            setTimeout(() => {
                                window.location="./";
                            }, <?php echo $array["time"]?>);
                        </script>
                    <?php
                }
            }
            else if(isset($array['url']))
            {
                if($array['url'] == "")
                {
                    ?>
                        <script>
                            window.location="./";
                        </script>
                    <?php
                }
                else
                {
                    ?>
                    <script>
                        window.location="<?php echo $array['url']?>";
                    </script>
                <?php  
                }
            }
        } catch(Error $e){
            return self::CreateAlert($e);
        }
    }
}

?>
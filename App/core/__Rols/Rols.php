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
     * 
     * Variable privada para instanciar el objeto Definitions
     */

    /** 
     * Function to check actual rol in some database
     * 
     * @return callable||null
     * 
     */
    public static function  Check($module, $condition , $function=null)
    {
        //Comprueba que la condicoin no sea nula
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
    }

    public static function ShowRol()
    {
        return self::GetRol();
    }

    

    // public function CheckPage(callable $call,$module="", $array=["message"=>"","time"=>1000,"url"=>""])
    // {
    //     if($this->Verified($module)==true)
    //     {
    //         return $call($param = null);
    //     }
    //     else
    //     {   
    //         $this->Choice($array);
    //     }
    // }
    
    public function Choice($array)
    {
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
    }
}


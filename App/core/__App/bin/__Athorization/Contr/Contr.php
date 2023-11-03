<?php

namespace Contr;

use DB;

class Contr
{
    public static function Choice($array)
    {
        if(isset($array["layout"]) != "")
        {
            echo $array["layout"];
        }
        if(isset($array["time"]) != "")
        {
            if(isset($array['url']))
            {
                if(isset($array['url']) === "")
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


    /**
     * Funcion para revisar que los parametros necesarios existen
     * 
     * @return boolen|string
     */
    private static function CheckParams($optionalparam="")
    {
        if($optionalparam == "")
        {
            if(isset($_POST['mail']) == true && isset($_POST['password']) == true)
            {
                $message = self::ValidateFields($_POST['mail'], $_POST['password']);
                if($message)
                {
                    return true;
                }
                else
                {
                    return $message;
                }
            }
            else{
                http_response_code(401);
                require_once  dirname(__FILE__,5)."/__Blocks/Folder/Views/401.php";
                return false;
            }
        }
        else
        {
            if( isset($_POST[$optionalparam]) == true && isset($_POST['password']) == true)
            {
                $message = self::ValidateFields($_POST[$optionalparam], $_POST['password']);
                if(is_string($message))
                {
                    return $message;
                }
                else
                {
                    return true;
                }
            }
            else{
                http_response_code(401);
                require_once  dirname(__FILE__,5)."/__Blocks/Folder/Views/401.php";
                return false;
            }
        }
        
    }

    private static function ValidateFields($param1, $param2)
    {
        if($param1 === "")
        {
            return "Campo de Correo Vacio";
        }
        else
        {
            if($param2 === "")
            {
                return "Campo de contraseña Vacio";
            }
            else
            {
                return true;
            }
        }
    }

    /**
     * Funcion para limpiar las cadenas y realizar la consulta
     * 
     * @return boolean|string
     */

    private static function Execute($model=null, $optionalparam="")
    {
        $con = DB::Instance();
        $check="";
        $qeury="";
        if($optionalparam === "")
        {
            $check = mysqli_real_escape_string($con->Connection(), $_POST['mail']);
            $query = "SELECT * FROM $model  WHERE mail = '$check'";
        }
        else
        {
            $check = mysqli_real_escape_string($con->Connection(), $_POST[$optionalparam]);
            $query = "SELECT * FROM $model  WHERE $optionalparam = '$check'";
        }
        
        $check2 = mysqli_real_escape_string($con->Connection(), $_POST['password']);
        $statement = mysqli_query($con->Connection(), $query);
        $result =self::CheckSteatment($statement, $check);
        if(count($result)>0)
        {
            $prepare = hash_hmac("sha256",$check2,"ffdcssxg45dd45s22s");
            if(password_verify($prepare, $result[0]['password']))
            {
                
                $_SESSION['id'] = $result[0]['id'];
                $_SESSION['log']=true;
                $_SESSION['Start']=time();
                $_SESSION['expire'] = $_SESSION['Start'] + (1000 * 6000);
                return self::CreateArray(self:: CreateSesion($model, $_SESSION['id']));
            }
            else
            {
                return "Password Incorrect";
            }
        }
        else
        {
            return "User not found, check the mail o the name";
        }
    }

    private static function CheckSteatment($statement)
    {
        $array = array();
        if($statement)
        {
            while($row = mysqli_fetch_assoc($statement))
            {
                array_push($array, $row);
            }
            return $array;
        }
    }

    private static function CreateSesion($model, $id)
    {
        $token= md5(uniqid(mt_rand(), true));
        $con = DB::Instance();
        $query =  "SELECT * FROM $model m JOIN tokens t ON m.id = t.user_id WHERE m.id = '$id'";
        $statement = mysqli_query($con->Connection(), $query);
        $result =self::CheckSteatment($statement);
        if(count($result) < 1)
        {
            $query = "INSERT INTO tokens (user_id, token) VALUES ('$id','$token')";
            $exe = mysqli_query($con->Connection(), $query);
            if($exe)
            {
                $_SESSION['token'] = $token;
                $query =  "SELECT * FROM $model m JOIN tokens t ON m.id = t.user_id WHERE m.id = '$id'";
                $statement = mysqli_query($con->Connection(), $query);
                $result =self::CheckSteatment($statement);
                return $result;
            }
        }
        else
        {
            $_SESSION['token'] = $token;
            return $result;
        }
    }

    public static function AccesLogin($model,$optionalparam = "")
    {
        $message = self::CheckParams($optionalparam);
        if($message === true)
        {
            $message2 =  self::Execute($model, $optionalparam);
            if(is_string($message2))
            {
                return $message2;
            }
            else
            {
                return $message2;
            }
        }
        else
        {
            return $message;
        }
    }

    private static function CreateArray($array)
    {
        $newarray = [];
        foreach ($array[0] as $key => $value) {
            if ($key !== "password") {
                $newarray[$key] = $value;
            }
        }
        return $newarray;
    }
}

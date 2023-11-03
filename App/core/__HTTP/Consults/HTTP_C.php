<?php

class Http_Consults
{
    
    function GETAPI($url, $method,$data=""){
        if($method=="POST")
        {
            $curl_connection = curl_init($url);
            curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl_connection, CURLOPT_USERAGENT, 
            "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($curl_connection);
            if($result==null)
            {
                echo curl_errno($curl_connection) . '-' . 
                curl_error($curl_connection);
                curl_close($curl_connection);
            }
            else{
                return $result;
            }
        }
        else if($method=="GET")
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL,  $url); /** Ingresamos la url de la api o servicio a consumir */
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); /**Permitimos recibir respuesta*/
            curl_setopt($curl, CURLOPT_HTTPGET,true);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_POST, false);
            $result = curl_exec($curl); /** Ejecutamos petición*/
            curl_close($curl);
            $body = $result;
            return $body;
        }
    }
    
    public function LOGIN($model,DB $con, $atrib="", $session=false)
    {
        if(isset($_SESSION['token'])==="")
        {
            echo "not found token";
        }
        else
        {
            $obj = new $model;
            $pass="";
            $mail ="";
            foreach ($model as $key => $value) {
                if($key=="password")
                {
                    $pass = $value;
                }
                if ($key == "mail") {
                    $mail = $value;
                }
            }
            foreach($model as $clave => $valor)
            {
                if($atrib=="")
                {
                    $cmd = "SELECT * FROM $obj->model_name WHERE mail = '$mail'";
                    $query = mysqli_query($con->Con(),$cmd);
                    $asoc = $query->fetch_assoc();
                    if($query->num_rows > 0)
                    {
                        if($this->VeryPass($pass, $asoc['password'])==true)
                        {
                            if($session==true)
                            {
                                $_SESSION['id'] = $asoc['id'];
                                $_SESSION['log']=true;
                                $_SESSION['Start']=time();
                                $_SESSION['expire'] = $_SESSION['Start'] + (1000 * 6000);
                                return true;
                            }
                            else
                            {
                                return true;
                            }
                        }
                        else
                        {
                            return "password incorrect";
                        }
                    }
                    else
                    {
                        return "record not found";
                    } 
                }
                else
                {
                    
                    if($atrib == $clave)
                    {
                        
                        $cmd = "SELECT * FROM $obj->model_name WHERE $atrib = '$valor'";
                        $query = mysqli_query($con->Con(),$cmd);
                        $asoc = $query->fetch_assoc();
                        if($query->num_rows > 0)
                        {
                            if($this->VeryPass($pass, $asoc['password'])==true)
                            {
                                if($session==true)
                                {
                                    $_SESSION['id'] = $asoc['id'];
                                    $_SESSION['token'] = md5(uniqid(mt_rand(), true));
                                    $_SESSION['log']=true;
                                    $_SESSION['Start']=time();
                                    $_SESSION['expire'] = $_SESSION['Start'] + (1000 * 6000);
                                    return true;
                                }
                                else
                                {
                                    
                                    return true;
                                }
                            }
                            else
                            {
                                return "password incorrect";
                            }
                        }
                        else
                        {
                            return "record not found";
                        } 
                    }
                }
            }
        }
    }
    public function VeryPass($password, $password_cypt)
    {
        $prepare = hash_hmac("sha256",$password,"ffdcssxg45dd45s22s");
        if(password_verify($prepare,$password_cypt))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}

function Bcrypt($password)
{
    $prepare = hash_hmac("sha256",$password,"ffdcssxg45dd45s22s");
    $timewait = 0.5;
    $cost = rand(0,10);
    $rand = rand(0,250);
    $salt = $rand;
    $options = array([
        'cost'=>$cost,
        'salt'=>$salt
    ]);
    $hash = password_hash($prepare,PASSWORD_BCRYPT,$options);
    return $hash;
}


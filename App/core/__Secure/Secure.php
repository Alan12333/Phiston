<?php
class Security
{
    
   

    public function RecoveryPass($mail="", $tbl="", $attribute="", $api = "", $range=4, $visible="hidden")
    {
        //It is necesary to create a recover table with the attributes idrecover, mail and code.
        
        include dirname(__FILE__,2)."/__Letter/Letter.php";
        $leter = new Letter();
        if($api=="")
        {
            include dirname(__FILE__,2)."/__DB/DB.php";
            $db = new DB();
            if($tbl=="")
            {
                return "Please write a table";
            }
            else if($attribute=="")
            {
                return "Please write a attribute";
            }
            else
            {
                if($db->driver=="mysql")
                {
                    $verify = $db->ExecuteRequest("SHOW TABLES like 'recover'")->num_rows;
                    if($verify>=1)
                    {
                        $code = $leter->Rands($range);
                        $comprobate = $db->ExecuteRequest("SELECT * FROM $tbl WHERE $attribute='$mail'")->num_rows;
                        if($comprobate>=1)
                        {
                            $comprobate2 = $db->ExecuteRequest("SELECT * FROM recover WHERE mail='$mail'")->num_rows;
                            if($comprobate2>=1)
                            {
                                $db->ExecuteRequest("UPDATE recover SET  code='$code' WHERE mail='$mail'");
                                $exe = $db->Asociate("SELECT code FROM recover WHERE mail='$mail'");
                                return $exe;
                            }
                            else
                            {
                                $db->Post("INSERT INTO recover(mail, code)VALUES('$mail', '$code')");
                                $exe = $db->Asociate("SELECT code FROM recover WHERE mail='$mail'");
                                return $exe;
                            }
                        }    
                        else
                        {
                            return "Not exist this e-mail";
                        }
                    }
                    else
                    {
                        return "Not exist table recover, please create it";
                    }
                }
            }
        }
        else
        {
            $verify = $api->COUNT("SHOW TABLES like 'recover'");
            if($verify>=1)
            {
                if($tbl=="")
                {
                    $api->PRINT("Please write a table");
                }
                else if($attribute=="")
                {
                    $api->PRINT("Please write a attribute");
                }
                else
                {
                    $code = $leter->Rands($range);
                    $comprobate = $api->COUNT("SELECT * FROM $tbl WHERE $attribute='$mail'");
                    if($comprobate>=1)
                    {
                        $comprobate2 = $api->COUNT("SELECT * FROM recover WHERE mail='$mail'");
                        if($comprobate2>=1)
                        {
                            if($visible=="hidden")
                            {
                                $api->PUT("UPDATE recover SET  code='$code' WHERE mail='$mail'");
                            }
                            else
                            {
                                $api->SAVE("UPDATE recover SET  code='$code' WHERE mail='$mail'");
                                return $api->ASSOCC("SELECT code FROM recover WHERE mail='$mail'");
                            }
                        }
                        else
                        {
                            if($visible=="hidden")
                            {
                                $api->POST("INSERT INTO recover(mail, code)VALUES('$mail', '$code')");
                            }
                            else
                            {
                                $api->SAVE("INSERT INTO recover(mail, code)VALUES('$mail', '$code')");
                                return $api->ASSOCC("SELECT code FROM recover WHERE mail='$mail'");
                            }
                        }
                    }    
                    else
                    {
                        $api->PRINT("Not exist this e-mail");
                    }
                }
            }
            else
            {
                $api->PRINT("Not exist table recover, please create it");
            }
        }
    }

    public function ComprobateCode($mail="", $code="", $api="")
    {   
        if($mail=="")
        {
            return "Error mail is empty";
        }
        else if($code == "")
        {
            return "Error code is empty";
        }
        else
        {
            if($api=="")
            {
                include dirname(__FILE__,2)."/__DB/DB.php";
                $db = new DB();
                $verify = $db->ExecuteRequest("SELECT * FROM recover WHERE mail = '$mail' AND code = '$code'")->num_rows;
                if($verify>=1)
                {
                    $db->ExecuteRequest("DELETE FROM recover WHERE mail='$mail'");
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                $verify = $api->COUNT("SELECT * FROM recover WHERE mail = '$mail' AND code = '$code'");
                if($verify>=1)
                {
                    $api->SAVE("DELETE FROM recover WHERE mail='$mail'");
                    $api->PRINT(true);
                }
                else
                {
                    $api->PRINT("false");
                }
            }
        }
    }

    public function ChangePassword($pass1="", $pass2="", $mail="", $tbl="", $attribute=["attribute1", "attribute2"], $api="", $type="crypt")
    {
        if(count($attribute)<=2)
        {
            if($api=="")
            {
                include dirname(__FILE__,2)."/__DB/DB.php";
                $db = new DB();
                if($pass1!=$pass2)
                {
                    return "Passwords do not match";
                }
                else
                {
                    if($db->driver=="mysql")
                    {
                        if($type=="crypt")
                        {
                            $newpass = $this->Password($pass1);
                        }
                        else
                        {
                            $newpass = $pass1;
                        }
                        $res = $db->ExecuteRequest("UPDATE $tbl SET $attribute[0] = '$newpass' WHERE $attribute[1] = '$mail'");
                        return $res;
                    }
                }
            }
            else
            {
                if($pass1!=$pass2)
                {
                    $api->PRINT("Passwords do not match");
                }
                else
                {
                    if($type=="crypt")
                    {
                        $newpass = $this->Password($pass1);
                    }
                    else
                    {
                        $newpass = $pass1;
                    }
                    $api->PUT("UPDATE $tbl SET $attribute[0] = '$newpass' WHERE $attribute[1] = '$mail'");
                }
            }
        }
        else
        {
            return "Index out of range, items range = 2 and you have ".count($attribute);
        }
    }
}

    // public function RecoveryPass( $tb="", $atrubutes=[], $values=[])
    // {
    //     include dirname(__FILE__,2)."/__DB/DB.php";
    //     include dirname(__FILE__,2)."/__Letter/Letter.php";
    //     $db = new DB();
    //     $leter = new Letter();
    //     if($db->driver=="mysql")
    //     {
    //         $atributs = implode(",",$atributes);
    //         $valores= implode("','", $values);
    //         $code = $leter->Rands(4);
    //         $db->Post("INSERT INTO $tb($atributes)VALUES($valores)");
    //         $db->ExecuteRequest("SELECT MAX(idrecovery) FROM recover");
    //     }
    // }


?>
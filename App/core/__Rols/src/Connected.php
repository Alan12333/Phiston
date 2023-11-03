<?php

class Conection
{
    public function executeconnection1($comand)
    {
        $con = DB::Instance();
        $result = mysqli_query($con->Connection(), $comand);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            return $row['id'];
        }
    }

    public function executeconnection2($comand)
    {
        $con = DB::Instance();
        $result = mysqli_query($con->Connection(), $comand);
        if($result->num_rows > 0)
        {
            return true;
        }
    }

    public function executefind($comand)
    {
        $array =array();
        $con = DB::Instance();
        $result = mysqli_query($con->Connection(), $comand);
        while($row=$result->fetch_array())
        {
            array_push($array, $row);
        }
    }

    public function FindRol($command)
    {
        $con = DB::Instance();
        $result = mysqli_query($con->Connection(), $command);
        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            return $row['rol_name'];
        }
    }
}


?>
<?php

class DB
{
    function __construct()
    {
        
    }
    
    function Con()
    {
        $conection= new mysqli("localhost","usr","pdw","db");
        mysqli_set_charset($conection, "utf8");
        return $conection;
    }

    function Close()
    {
        return mysqli_close($this->Con());
    }
    function __destruct()
    {
        
    }
}
?>
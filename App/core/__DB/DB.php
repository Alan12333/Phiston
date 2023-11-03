<?php

class DB
{
    private $con;
    private static $instance;
    private $database, $host, $user, $pass,$driver, $port, $charset;

    function __construct()
    {
        $this->GetVariables();
    }
    
    private function GetVariables()
    {
        $dbconfig = require_once(dirname(__FILE__,4).'/.enviroment');
        if(is_array($dbconfig)==true)
        {
            $this->database = $dbconfig['database'];
            $this->host = $dbconfig['host'];
            $this->user = $dbconfig['user'];
            $this->pass = $dbconfig['pass'];
            $this->charset = $dbconfig['charset'];
            $this->port = $dbconfig['port'];
            $this->driver = $dbconfig['driver']; 
            if($this->driver=="mysql" || $this->driver=="")
            {
                $this->con = new mysqli($this->host, $this->user, $this->pass,  $this->database);
                mysqli_set_charset($this->con, $this->charset);
            }
        }
    }

    public static function Instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function Connection()
    {
        return $this->con;
    }
}
?>
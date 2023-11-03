<?php
include (dirname(__FILE__).'/Connected.php');
class Constructs
{
    /**
     * 
     * Definición de las palabras clave para conectar, con ciertos caracteres
     * 
     * 
     * @var string[]
     * 
     * 
     */
    protected  $words = [
        "S%(/E/%%L/%$%E%/()/$%C%$#//()(T",
        "F!?=%/R&%$&%/O%&$/M%$#$",
        "#$%W$%&H&$%//(%E%$%&R)=?/(%\/E$%@", 
        "&%$#A()?&%N#!&$&D/(&=",
        "%$$%J$&56O?3422#I$.&5N/()#",
        "**/&O#$%N!?¡=",
    ];
    /**
     * 
     * 
     * Definicion de los parametros en la base de datos
     * 
     * @var string[]
     * 
     * 
     */
    protected  $params = ["rol", "rol_name", "user_rol", "id_user", "id_rol", "id"];
    /**
     * 
     * Definicion de la palabra del rol 
     * 
     * @var string
     * 
     * 
     */
    protected $rolname = "";

    private $con;
    /**
     * 
     * Se puede cambiar por un id dinámico o dejarlo vació, tomara como referencia el id del usuario actual.
     * 
     * 
     * @var int
     * 
     */
    public $id = 0;
    private $rols=[];

    /**
     * 
     * Pide el nombre del rol a verificar en relación con los usuarios
     */
    function __construct($rolname = "")
    {
        $this->rolname = $rolname;
        $this->con = new Conection();
        if($this->id === 0)
        {
            $this->id = Ses::id();
        }
    }

    public function Gets()
    {
        $this->con->executefind($this->createget());
    }

    public function Execute()
    {
        $id = $this->con->executeconnection1($this->Create());
        if($id !== false)
        {
            if($this->con->executeconnection2($this->create_consult($id)) === true)
            {
                return true;
            }
        }

    }

    public function GetRol()
    {
        $user = $this->con->FindRol($this->Constructconsult());
        return $user;
    }

    private function Create()
    {
        $consult = $this->Decifred(0).self::AddChar().$this->Decifred(1)." ".$this->params[0]." ".
        $this->Decifred(2)." ".$this->params[1].self::AddChar(1)."'".$this->rolname."';";
        return $consult;
    }

    private function create_consult($id)
    {
        $consult = $this->Decifred(0).self::AddChar().$this->Decifred(1)." ".$this->params[2]." ".
        $this->Decifred(2)." ".$this->params[3].self::AddChar(1)." '". $this->id ."' ".$this->Decifred(3).
        " ".$this->params[4].self::AddChar(1)."'".$id."';";
        return $consult;
    }

    private function createget()
    {
        $consult = $this->Decifred(0).self::AddChar().$this->Decifred(1)." ".$this->params[0].";";
        return $consult;
    }

    private function Constructconsult()
    {
        $consult = $this->Decifred(0).self::AddChar().$this->Decifred(1)." ".$this->params[0]." r ".
        $this->Decifred(4)." ".$this->params[2]." ur ".$this->Decifred(5)." r.".$this->params[5].self::AddChar(1).
        "ur.".$this->params[4]." ".self::Decifred(2)." ur.".$this->params[3].self::AddChar(1)."'".Ses::id()."';";
        return $consult;
    }

    private  function Decifred($pos)
    {
        $pattern = '/[^a-zA-Z]/'; //Expresion regular para encontrar caracteres no alfabeticos.
        $this->words[$pos] = preg_replace($pattern, '', $this->words[$pos]);
        return $this->words[$pos];
    } 

    private static  function AddChar($char=2)
    {
        if($char === 1)
        {
            return  " = ";
        }
        else
        {
            return  " * ";
        }
    }
}
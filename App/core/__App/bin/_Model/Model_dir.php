<?php


class Model_Dir
{
    private $sql_select;
    private  $model_name;
    private $model;
    public $atributes=[];
    public $values=[];
    private $table="";

    function __construct( $model_name, Model $model)
    {
        $this->model = $model;
        $this->model_name = $model_name;
    }

    public function SELECT(...$array)
    {
        $isatrib = count($array[0]);
        if($isatrib === 0)
        {
            if($this->table === "")
            {
                $this->sql_select = "SELECT * FROM $this->model_name ".$this->ObtenerAlias()." ;";
            }
            else
            {
                $this->sql_select = "SELECT * FROM $this->table ".$this->ObtenerAlias()." ;";
            }
        }
        else
        {
            $cadena = implode(",",$array[0]);
            if($this->table === "")
            {
                $this->sql_select = "SELECT $cadena FROM $this->model_name ".$this->ObtenerAlias()." ;";
            }
            else
            {
                $this->sql_select = "SELECT $cadena FROM $this->table ".$this->ObtenerAlias()." ;";
            }
        }
    }
    private function ObtenerAlias()
    {
        $array =[];
        $newalias = [];
        $array = str_split($this->model_name);
        $newalias[] = $array[0];
        $newalias[] = $array[1];
        $newalias[] = $array[2];
        $alias = implode("",$newalias);
        return $alias;
    }

    public function TABLE($table)
    {
        $this->table = $table;
        return $this;
    }

    public function FIND($id, ...$params)
    {
        $isatrib = count($params[0]);
        if($id === "")
        {
            $id=1;
        }
        if($isatrib === 0)
        {
            $this->sql_select = "SELECT * FROM $this->model_name WHERE id = $id";
        }
        else
        {
            $cadena = implode(",",$params[0]);
            $this->sql_select = "SELECT $cadena FROM $this->model_name WHERE id = $id";
        }
        $res = [];
        $db = DB::Instance();
        $sql = mysqli_query($db->Connection(),$this->sql_select);
        while($row =  mysqli_fetch_assoc($sql))
        {
            $res[] = $row;
        }
        return $res;
    }
    public function DESC($atr = "")
    {
        if($atr === "")
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." ORDER BY id DESC";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." ORDER BY $atr DESC";
        }
    }
    public function ASC($atr = "")
    {
        if($atr === "")
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." ORDER BY id ASC";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." ORDER BY $atr ASC";
        }
    }

    

    public function COUNT($atr,$name="")
    {
        $cadena = explode(" ",$this->sql_select);
        if($cadena[1] == "*")
        {
            if($name == "")
            {
                $cadena[1] = " COUNT($atr) ";
            }
            else
            {
                $cadena[1] = " COUNT($atr) AS $name ";
            }
        }
        else
        {
            if($name == "")
            {
                $cadena[2] = $cadena[2].", COUNT($atr) ";
            }
            else
            {
                
                $cadena[2] = $cadena[2].", COUNT($atr) AS $name ";
            }
        }
        $this->sql_select = implode(" ",$cadena);
    }
    public function DISTINCT($atr,$name="")
    {
        $cadena = explode(" ",$this->sql_select);
        if($cadena[1] == "*")
        {
            if($name == "")
            {
                $cadena[1] = " DISTINCT($atr) ";
            }
            else
            {
                $cadena[1] = " DISTINCT($atr) AS $name ";
            }
        }
        else
        {
            if($name == "")
            {
                $cadena[2] = $cadena[2].", DISTINCT($atr) ";
            }
            else
            {
                
                $cadena[2] = $cadena[2].", DISTINCT($atr) AS $name ";
            }
        }
        $this->sql_select = implode(" ",$cadena);
    }



    public function ROWS()
    {
        $db = DB::Instance();
        $sql = mysqli_query($db->Connection(),$this->sql_select);
        $res = ["num_rows"=>$sql->num_rows];
        return $res;
    }

    public function WHERE($atr ="",$type="",$value="")
    {
        if($atr=="" && $value = "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." WHERE $atr $type '$value';";
        }
    }

    public function AND($atr ="",$type="",$value="")
    {
        if($atr=="" && $value = "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            if($value=="NULL")
            {
                $this->sql_select = $separate[0]." AND $atr $type NULL";
            }
            else
            {
                $this->sql_select = $separate[0]." AND $atr $type '$value'";
            }
        }
    }

    public function IF($condition)
    {
        $separate = explode(";",$this->sql_select);
        $this->sql_select = $separate[0]." $condition ;";
    }


    public function OR($atr ="",$type="",$value="")
    {
        if($atr=="" && $value = "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            if($value=="NULL")
            {
                $this->sql_select = $separate[0]." OR $atr $type NULL";
            }
            else
            {
                $this->sql_select = $separate[0]." OR $atr $type '$value'";
            }
        }
    }

    public function JOIN($table="",$atrb="", $operator="", $atrb2="")
    {
        if($table == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." JOIN $table ON $atrb $operator $atrb2;";
        }
    }

    public function INNERJOIN($table="",$atrb="", $operator="", $atrb2="")
    {
        if($table == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." INNER JOIN $table ON $atrb $operator $atrb2;";
        }
    }

    public function LEFT_JOIN($table="",$atrb="", $operator="", $atrb2="")
    {
        if($table == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." LEFT JOIN $table ON $atrb $operator $atrb2;";
        }
    }

    public function RIGHT_JOIN($table="",$atrb="", $operator="", $atrb2="")
    {
        if($table == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." RIGHT_JOIN $table ON $atrb $operator $atrb2;";
        }
    }

    public function LIMIT($limit)
    {
        if($limit == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." LIMIT $limit;";
        }
    }

    public function IS_NULL($atr)
    {
        if($atr == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." WHERE $atr IS NULL;";
        }
    }

    public function IS_NOT_NULL($atr)
    {
        if($atr == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." WHERE $atr IS NOT NULL;";
        }
    }

    public function OR_WHERE_NULL($atrb)
    {
        if($atrb == "")
        {
            $this->sql_select="Error";
        }
        else
        {
            $separate = explode(";",$this->sql_select);
            $this->sql_select = $separate[0]." OR $atrb IS NULL;";
        }
    }

    public function GET()
    {
        $res = [];
        $db = DB::Instance();
        if($this->sql_select == "")
        {
            $sql = mysqli_query($db->Connection(),"SELECT * FROM $this->model_name;");
        }
        else
        {
            $sql = mysqli_query($db->Connection(),$this->sql_select);
        }
        while($row =  mysqli_fetch_assoc($sql))
        {
            $res[] = $row;
        }
        return $res;
    }

    public function PRINT()
    {
        $res = [];
        $db = DB::Instance();
        if($this->sql_select == "")
        {
            $sql = mysqli_query($db->Connection(),"SELECT * FROM $this->model_name;");
        }
        else
        {
            $sql = mysqli_query($db->Connection(),$this->sql_select);
        }
        while($row =  mysqli_fetch_assoc($sql))
        {
            $res[] = $row;
        }
        return $res;
    }

    public function PRINTSQL()
    {
        return $this->sql_select;
    }

    public function GROUPBY(...$array)
    {
        $cadena = implode(",",$array[0]);
        $separate = explode(";",$this->sql_select);
        $this->sql_select = $separate[0]." GROUP BY $cadena;";
    }

    public function Pagination( $numpage = 10, $page=1)
    {
        $db = DB::Instance();
        $resultado = mysqli_query($db->Connection(), $this->sql_select)->num_rows;
        $numero_de_paginas = ceil($resultado / $numpage);
        $inicio = ($page - 1) * $numpage;
        $separate = explode(";",$this->sql_select);
        $cmd = $separate[0]." LIMIT $inicio, $numpage;";
        $this->sql_select = $cmd;
    }

    //Metodos de tipo HTTP

    public function DeleteRecords($arg="",$token="")
    {
        if($token != "")
        {
            if($token===Ses::Token())
            {
                $this->ActionDelete($arg);
            }
            else
            {
                $db = DB::Instance();
                $cmd = "SELECT * FROM tokens AS token WHERE token='$token'";
                $row = mysqli_query($db->Connection(), $cmd)->num_rows;
                if($row > 0)
                {
                    $this->ActionDelete($arg);
                }
                else
                {
                    return 401;
                }
            }
        }
        else
        {
            return 401;
        }
    }

    private function ActionDelete($arg="")
    {
        $db = DB::Instance();
        $res = $this-> ObtenerAtributos();
        if($res === "Not typed of HTTP ENTER")
        {
            http_response_code(405);
        }
        else
        {
            $id="";
            $i=0;
            foreach($this->atributes as $item)
            {
                if($this->values[$i] != "")
                {
                    
                    if($arg == "")
                    {
                        if($item === 'id')
                        {
                            $id = $this->values[$i];
                        }
                    }
                    else
                    {
                        if($item === $arg)
                        {
                            $id = $this->values[$i];
                        }
                    }
                }
                $i++;
            }
            if($arg=="")
            {
                $cmd = "DELETE FROM $this->model_name WHERE id='$id'";
                $res_consulta = mysqli_query($db->Connection(),$cmd);
            }
            else
            {
                $cmd = "DELETE FROM $this-> model_name WHERE $arg='$id'";
                echo $cmd;
                // $res_consulta = mysqli_query($db->Connection(),$cmd);
            }
            return $res_consulta;
        }
    }

    public function UpdateRecords($arg = "",$value="",$token="")
    {
        if($token != "")
        {
            if($token === Ses::Token())
            {
                return $this->AccesUpdateValues($arg,$value);
            }
            else
            {
                $db = DB::Instance();
                $cmd = "SELECT * FROM tokens AS token WHERE token='$token'";
                $row = mysqli_query($db->Connection(), $cmd)->num_rows;
                if($row > 0)
                {
                    return $this->AccesUpdateValues($arg,$value);
                }
                else
                {
                    return 401;
                }
            }
        }
        else
        {
            return 401;
        }
    }

    private function AccesUpdateValues($arg="",$value="")
    {
        $res = $this->ObtenerAtributos();
    
        if ($res === "Not typed of HTTP ENTER") {
            http_response_code(405);
            return;
        }

        $nuevosvalores = [];
        $id = "";
        foreach ($this->values as $subarreglo) {
            foreach ($subarreglo as $clave => $valor) {
                if ($clave === 'id') {
                    $id = $valor;
                } else {
                    $nuevosvalores[$clave] = $valor;
                }
            }
        }
        
        $db = DB::Instance();
        $consulta = "";
        if ($arg === "") {
            $cmd = "UPDATE $this->model_name SET ";
            
            foreach ($nuevosvalores as $clave => $valor) {
                $cmd .= "$clave = ?, ";
            }

            $cmd = rtrim($cmd, ', ');
            $cmd .= " WHERE id = ?";
            $stmt = mysqli_prepare($db->Connection(), $cmd);

            $tipos = str_repeat('s', count($nuevosvalores)) . 's';
            $valores = array_values($nuevosvalores);
            $valores[] = $id;

            mysqli_stmt_bind_param($stmt, $tipos, ...$valores);

            $consulta = mysqli_stmt_execute($stmt);
        } else {
            $cmd = "UPDATE $this->model_name SET $arg = ? WHERE id = ?";
            $stmt = mysqli_prepare($db->Connection(), $cmd);

            mysqli_stmt_bind_param($stmt, 'ss', $value, $id);

            $consulta = mysqli_stmt_execute($stmt);
        }
        return $consulta;
    }

    public function SaveRecords($arg = "", $token="")
    {
        if($token != "")
        {
            if($token == Ses::Token())
            {
                return $this->AccesSave($arg);
            }
            else
            {
                $db = DB::Instance();
                $cmd = "SELECT * FROM tokens AS token WHERE token='$token'";
                $row = mysqli_query($db->Connection(), $cmd)->num_rows;
                if($row > 0)
                {
                    return $this->AccesSave($arg);
                }
                else
                {
                    return 401;
                }
            }
        }
        else
        {
            return 401;
        }
    }

    public function extractvalue($valor)
    {
        if($valor != "")
        {
            $this-> ObtenerAtributos();
            return $this->model->$valor;
        }
        else{
            $this->ObtenerAtributos();
        }
    }

    private function AccesSave($arg="")
    {
        
        $cadena2 = "";
        $cadena1 = "";
        $obtener = $this-> ObtenerAtributos();
        if($obtener === "Not typed HTTP ENTER")
        {
            http_response_code(405);
        }
        else
        {
            $cadena1 = implode(",",$this->atributes);
            $valor = [];
            $consulta = "";
            foreach($this->values as $item)
            {
                if($item === null)
                {
                    $valor[] = 'NULL';
                }
                else
                {
                    $valor[] = "'".$item."'";
                }
            }
            $cadena2 = implode(",",$valor);
            $db = DB::Instance();
            $cmd = "INSERT INTO $this->model_name ($cadena1) VALUES ($cadena2);";
            $sql1 = mysqli_query($db->Connection(),$cmd);
            if($arg === "") 
            {
                if($sql1 == true)
                {
                    $consulta = mysqli_query($db->Connection(),"SELECT * FROM $this->model_name ORDER BY id DESC LIMIT 1")->fetch_assoc();
                }
            }
            else if($arg === true)
            {
                if($sql1 == true)
                {
                    $consulta = 'true';
                }
            }
            else
            {  
                if($sql1 == true)
                {
                    $consulta = mysqli_query($db->Connection(),"SELECT $arg FROM $this->model_name ORDER BY id DESC LIMIT 1")->fetch_assoc();
                }
            }
            return $consulta;
        }
    }

    public function ObtenerAtributos()
    {
        $this->values=[];
        $this->atributes = [];
        $attributes = [];
        $db = DB::Instance();
        $sql = "DESCRIBE $this->model_name";
        $result = mysqli_query($db->Connection(),$sql);
        while ($field = mysqli_fetch_assoc($result)) {
            array_push($attributes, $field['Field']);
        }
        $json = json_encode($attributes);
        $desjson = json_decode($json);
        foreach($desjson as $item => $key)
        {
            if(isset($_POST[$key]))
            {
                if($this->model->$key == "")
                {
                    $this->model->$key = mysqli_real_escape_string($db->Connection(), $_POST[$key]);
                    $this->CheckAtributtes($key, $_POST[$key]);
                }
                if(isset($_POST['method']))
                {
                    $method = $_POST['method'];
                    if($method === "POST" || $method === "DELETE")
                    {
                        $this->DefineValues($key);
                    }
                    else if($method === "PUT" )
                    { 
                        $this->DefineValues2($key);
                    }
                }
                else{
                    return "Not typed of HTTP ENTER";
                }
            }
            else
            {
                if(isset($_POST['method']))
                {
                    $method = $_POST['method'];
                    if($this->model->$key != "")
                    {
                        $this->CheckAtributtes($key, $this->model->$key);
                        if($method === "POST" || $method === "DELETE")
                        {
                            $this->DefineValues($key);
                        }
                        else if($method === "PUT" )
                        { 
                            $this->DefineValues2($key);
                        }
                    }
                }
                else{
                    return "Not typed of HTTP ENTER";
                }
            }
        }
    }

    private function DefineValues2($atrib) //Esta funcion evita que los atributos y valores se dupliquen
    {
        if(in_array($atrib, $this->atributes)==false)
        {
            $this->atributes[] = $atrib;
        }
        
        if(in_array($this->model->$atrib, $this->values)==false)
        {
            $this->values[] =[$atrib => $this->model->$atrib];
        }
    }

    private function DefineValues($atrib) //Esta funcion es para los metodos POST Y DELETE
    {
        if(in_array($atrib, $this->atributes)==false)
        {
            $this->atributes[] = $atrib;
        }
        $this->values[] = $this->model->$atrib;
    }

    private function CheckAtributtes($atributte, $value)
    {
        if(method_exists($this->model,"Encrypt")==true)
        {
            $array = $this->model->bcrypt();
            foreach($array as $item)
            {
                if($item == $atributte)
                {
                    $this->model->$item = $this->Bcrypt($value);
                }
            }
        }
    }

    private function Bcrypt($password)
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

    public function findlast($atrb)
    {
        if($this->table === "")
        {
            $db = DB::Instance();
            $query = "SELECT $atrb FROM $this->model_name ORDER BY id DESC LIMIT 1";
            $consulta = mysqli_query($db->Connection(), $query);
            $result = $consulta->fetch_assoc();
            return $result[$atrb];
        }
        else{
            $db = DB::Instance();
            $query = "SELECT $atrb FROM $this->table ORDER BY id DESC LIMIT 1";
            $consulta = mysqli_query($db->Connection(), $query);
            $result = $consulta->fetch_assoc();
            return $result[$atrb];
        }
    }

    public function findfirst($atrb)
    {
        if($this->table === "")
        {
            $db = DB::Instance();
            $query = "SELECT $atrb FROM $this->model_name ORDER BY id ASC LIMIT 1";
            $consulta = mysqli_query($db->Connection(), $query);
            $result = $consulta->fetch_assoc();
            return $result[$atrb];
        }
        else
        {
            $db = DB::Instance();
            $query = "SELECT $atrb FROM $this->table ORDER BY id ASC LIMIT 1";
            $consulta = mysqli_query($db->Connection(), $query);
            $result = $consulta->fetch_assoc();
            return $result[$atrb];
        }
    }
}
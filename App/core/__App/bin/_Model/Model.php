<?php
include dirname(__FILE__)."/Model_dir.php";

class Model
{
    private  $result = "";
    private  $consults;
    private  $model_name;
    private  $model;

    function __construct($model_name,$model)
    {
        $this->model = $model;
        $this->model_name = $model_name;
        $this->consults = new Model_Dir($model_name, $model);
    }
    public function TABLE($table)
    {
        $this->consults->TABLE($table);
        return $this;
    }
    public function SELECT(...$array)
    {
        $this->result = $this->consults->SELECT($array);
        return $this;
    }

    function DESC($atrb="")
    {
        $this->result = $this->consults->DESC($atrb);
        return $this;
    }
    function ASC($atrb="")
    {
        $this->result = $this->consults->ASC($atrb);
        return $this;
    }
    function LIMIT($limit)
    {
        $this->result = $this->consults->limit($limit);
        return $this;
    }
    function ROWS()
    {
        $this->result =  $this->consults->ROWS();
        $data = json_encode($this->result,JSON_UNESCAPED_UNICODE);
        return json_decode($data,true);
    }

    function WHERE( $atr ="",$type="",$value="")
    {
        $this->result = $this->consults->WHERE($atr,$type,$value);
        return $this;
    }


    function AND( $atr ="",$type="",$value="")
    {
        $this->result = $this->consults->AND($atr,$type,$value);
        return $this;
    }
    function OR($atr ="",$type="",$value="")
    {
        $this->result = $this->consults->OR($atr,$type,$value);
        return $this;
    }

    function IF($condition)
    {
        $this->result = $this->consults->IF($condition);
        return $this;
    }

    function JOIN($table = "",$atrb="", $operator="", $atrb2="")
    {
        $this->result = $this->consults->JOIN($table, $atrb, $operator, $atrb2);
        return $this;
    }
    function INNER_JOIN($table = "",$atrb="", $operator="", $atrb2="")
    {
        $this->result = $this->consults->INNERJOIN($table,$atrb, $operator, $atrb2);
        return $this;
    }
    function LEFT_JOIN($table = "",$atrb="", $operator="", $atrb2="")
    {
        $this->result = $this->consults->LEFT_JOIN($table,$atrb, $operator, $atrb2);
        return $this;
    }

    function RIGHT_JOIN($table = "",$atrb="", $operator="", $atrb2="")
    {
        $this->result = $this->consults->RIGHT_JOIN($table,$atrb, $operator, $atrb2);
        return $this;
    }
    function IS_NULL($atr)
    {
        $this->result = $this->consults->IS_NULL($atr);
        return $this;
    }
    function IS_NOT_NULL($atr)
    {
        $this->result = $this->consults->IS_NOT_NULL($atr);
        return $this;
    }
    function OR_WHERE_NULL($atr)
    {
        $this->result = $this->consults->OR_WHERE_NULL($atr);
        return $this;
    }
    function FINDLAST($atribute)
    {
        return $this->consults->findlast($atribute);
    }
    function FINDFIRST($atribute)
    {
        return $this->consults->findfirst($atribute);
    }
    function GROUPBY($array = [])
    {
        $this->result = $this->consults->GROUPBY($array);
        return $this;
    }
    function COUNT($atr,$name="")
    {
        $this->result = $this->consults->COUNT($atr,$name);
        return $this;
    }
    function DISTINCT($atr,$name="")
    {
        $this->result = $this->consults->DISTINCT($atr,$name);
        return $this;
    }
    
    public function GET()
    {
        $this->result =  $this->consults->GET();
        $data = json_encode($this->result,JSON_UNESCAPED_UNICODE);
        return json_decode($data,true);
    }
    public function PRINT()
    {
        header("Content-Type:application/json");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        $this->result =  $this->consults->PRINT();
        $data = json_encode($this->result);
        echo $data;
    }
    public function PRINTSQL()
    {
        $this->result =  $this->consults->PRINTSQL();
        $data = json_encode($this->result);
        echo json_decode($data);
    }
    function FIND($id=1, ...$params)
    {
        $this->result = $this->consults->FIND($id, $params);
        $data = json_encode($this->result,JSON_UNESCAPED_UNICODE);
        return json_decode($data,true);
    }

    public function Pagination($num_page=10,$page=1)
    {
        $this->result =  $this->consults->Pagination($num_page,$page);
        return $this;
    }
    public function extractvalue($value="")
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['method']) == "POST")
            {
                if(isset($_POST['token']))
                {
                    if(Ses::Token() == $_POST['token'])
                    {
                        return $this->consults->extractvalue($value);
                    }
                    else
                    {
                        $db = db::Instance();
                        $query = "SELECT * FROM tokens WHERE token ='$_POST[token]'";
                        $sql = mysqli_query($db->Connection(), $query);
                        if($sql->num_rows > 0)
                        {
                            return $this->consults->extractvalue($value);
                        }
                        else
                        {
                            http_response_code(401);
                            require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
                        }
                    }
                } else {
                    http_response_code(401);
                    require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
                }
            }
            else
            {
                http_response_code(401);
                require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
            }
        }
        else
        {
            http_response_code(401);
            require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
        }
    }
    public function PUT($arg="",$valor="")
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['token']))
            {
                $_token = $_POST['token'];
                if($arg=="")
                {
                    $sqlres = $this->consults->UpdateRecords($arg,$valor,$_token);
                    if($sqlres === true)
                    {
                        http_response_code(200);
                        $data = json_encode("true",JSON_UNESCAPED_UNICODE);
                        return json_decode($data);
                    }
                }
                else
                {
                    $sqlres = $this->consults->UpdateRecords($arg,$valor,$_token);
                    if($sqlres === true)
                    {
                        http_response_code(200);
                        $data = json_encode(true,JSON_UNESCAPED_UNICODE);
                        return json_decode($data,true);
                    }
                    else
                    {
                        http_response_code(401);
                        require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
                    }
                }
            }
            else
            {
                
                http_response_code(401);
                require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
            }
        }
        else
        {
            http_response_code(401);
            require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
        }
    }

    public function send($atrib, $value)
    {
        $_POST[$atrib] = $value;
    }

    public function extractsend($atr)
    {
        if(isset($_POST[$atr]))
        {
            return $_POST[$atr];
        }
    }

    public function POST($arg="")
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['token']))
            {
                $_token = $_POST['token'];
                if($arg=="")
                {
                    $sqlres = $this->consults->SaveRecords($arg,$_token);
                    if( $sqlres != 401)
                    {
                        http_response_code(200);
                        $data = json_encode($sqlres,JSON_UNESCAPED_UNICODE);
                        return json_decode($data);
                    } 
                }
                else
                {
                    
                    $sqlres = $this->consults->SaveRecords($arg,$_token);
                    if($sqlres != 401)
                    {
                        if(is_array($sqlres)===true)
                        {
                            http_response_code(200);
                            $data = json_encode($sqlres,JSON_UNESCAPED_UNICODE);
                            return json_decode($data);
                            
                        } 
                        else if($sqlres == true)
                        {
                            echo "true";
                            return true;
                        }
                    }
                }
            }
            else
            {
                http_response_code(401);
                require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
            }
        }
        else
        {
            http_response_code(401);
            require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
        }
    }

    public function DELETE($arg="")
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['token']))
            {
                $_token = $_POST['token'];
                if($arg=="")
                {
                    if($this->consults->DeleteRecords($arg, $_token) != 401)
                    {
                        http_response_code(200);
                        echo 'true';
                        return true;
                    }
                }
                else
                {
                    if($this->consults->DeleteRecords($arg, $_token) != 401)
                    {
                        http_response_code(200);
                        return true;
                    }
                }
            }
            else
            {
                http_response_code(401);
                require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
            }
        }
        else
        {
            http_response_code(401);
            require_once  dirname(__FILE__,4)."/__Blocks/Folder/Views/401.php";
        }
    }

    public function GetData()
    {
        $this->consults->ObtenerAtributos();
    }
}
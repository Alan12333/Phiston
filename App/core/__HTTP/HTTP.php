<?php
include dirname(__FILE__)."/Consults/HTTP_C.php";
include dirname(__FILE__)."/Consults/VirtualHTTP.php";

class HTTP 
{
    public $con;
    public $models;
    public $consults;
    private $result;
    public $sql_select;

    private $model_function;

    private $consult;

    private $virtual;

    private $virtualmodel;

    function __construct()
    {
        $this->consults = new HTTP_Consults();
        $this->virtual = new VIRTUALHTTP;
    }

    public function receive($param="", $type="POST")
    {
        if($_SERVER['REQUEST_METHOD'] === "POST")
        {
            if(isset($_POST['token']))
            {
                return $this->model_function->Obtain($this->con,$param,$type);
            }
            else
            {
                require_once  dirname(__FILE__,2)."/__Blocks/Folder/Views/401.php";
            }
        }
        else
        {
            require_once  dirname(__FILE__,2)."/__Blocks/Folder/Views/401.php";
        }
        
    }


    public function LOGIN($atrib="", $session=false)
    {
        $this->model_function->GetPOST($this->con);
        if($atrib=="")
        {
            return $this->consults->LOGIN($this->models,$this->con, "", $session);
        }
        else
        {
            return $this->consults->LOGIN($this->models,$this->con,$atrib, $session);
        }
    }


    public function GETAPI($url,$method="GET", $body=[])
    {
        if($method == "POST")
        {
            $post_items=[];
            foreach ($body as $key => $value) {
                $post_items[] = $key . '=' . $value;
            }
            $post_string = implode ('&', $post_items);
            return $this->consults->GETAPI($url,$method,$post_string);
        }
        else
        {
            return $this->consults->GETAPI($url,$method);
        }
    }
    public function PRINT($atr="")
    {
        header("Content-Type:application/json");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Allow: GET, POST, OPTIONS, PUT, DELETE");
        if($atr==="")
        {
            echo json_encode($this->result, JSON_UNESCAPED_UNICODE);
        }
        else
        {
            echo json_encode($atr, JSON_UNESCAPED_UNICODE);
        }
        return $this;
    }
}



?>

<?php
require_once("inputfilter.php");
/*Esta es pagina de carga del nucleo principal*/
class Modules
{
    public $title;
    public $style;
    public $script;
    public $view;

    public function LoadViewPage($vista, $title)
    {
        $style=$vista;
        $scripts=$vista;
        $propose="1";
        require_once('req.php');
        require_once('phis.php');
        try {
            require_once('Views/'.$vista.'/'.$vista.'.struct.php');   
            require_once('Views/'.$vista.'/'.$vista.'.index.php');
        } catch (Exception $err) {
            echo $err;
        }
    }
    public function LoadViewPageGSJ($vista, $title)
    {
        $style=$vista;
        $scripts=$vista;
        $propose="2";
        require_once('req.php');
        include('phis.php');

    }
    public function RutePage($vista,$location, $title)
    {
        $style=$vista;
        $scripts=$vista;
        $loc = $location;
        $propose="4";
        require_once('req.php');
        include('phis.php');
    }
    public function LoadViewPageVue($vista, $title)
    {
        $style=$vista;
        $scripts=$vista;
        $propose="3";
        require_once('req.php');
        include('phis.php');
        
    }
    public function LoadPage($vista, $title)
    {
        $style=$vista;
        $scripts=$vista;
        $propose="1";
        require_once('req.php');
        include('phis.php');
        
        
    }
    public function PageView($vista,$titulo,$params)
    {
        $style=$vista;
        $scripts=$vista;
        $title=$titulo;
        $propose='2';
        require_once('req.php');
        include('phis.php');
    }

    public function PageParamView($vista,$title,$params)
    {
        $style=$vista;
        $scripts=$vista;
        $propose='2';
        require_once('req.php');
        include('phis.php');
        
    }



    //Databases

    public function ExecuteQuery($cmd, $con)
    {
        $mysql = mysqli_query($con, $cmd);
        if($mysql)
        {
            return $mysql;
        }
        else
        {
            echo "<div class='cont-100 bkr wh cen'>Errormessage: ".mysqli_errno($con)." You have an error in your SQL syntax</div>";
        }
    }
    
    public function ExecuteQueryJSON($query, $con)
	{
        
		$res=array();
		$res_consulta=mysqli_query($con,$query);
		while($row=mysqli_fetch_assoc($res_consulta))
		{
            array_push($res,$row);
		}
		return $res;
	}

    public function Asociate($cmd, $con)
    {
        $mysql = mysqli_query($con, $cmd);
        $row=mysqli_fetch_assoc($mysql);
        if($mysql)
        {
            return $row;
        }
        else
        {
            echo "error";
        }
    }

    public function AsociateString($string)
    {
        $row=mysqli_fetch_array($string);
        return $row;
    }
    
    public function CountRows($cmd, $con)
    {
        $mysql=mysqli_query($con, $cmd);
        $variable = $mysql->num_rows;
        return $variable;
    }


    //Seguridad
    public function SecureString($con,$string)
    {
        $cadena = $con->real_escape_string($string);
        return $cadena;
    }

    public function Clean_Filters($filters, $atributo)
    {

    }

    public function Clean($atributo)
    {
        $inputfilter = new InputFilter(array('p','scipt','div','a','b','br','i','li','ul','img'), array('src','href'));
        return $inputfilter->process($atributo);
    }

    public function Filters($etiquetas,$atributos)
    {
        $inputfilter = new InputFilter();
    }

    public function SetHr($zone, $format)
    {
        if($zone=="MXN" || $zone=="mxn")
        {
            date_default_timezone_set('America/Mexico_City');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return strftime($format);
        }
        else if($zone =="ARG" || $zone =="arg")
        {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return strftime($format);
        }
        else if($zone =="BRZ" || $zone =="brz")
        {
            date_default_timezone_set('America/Sao_Paulo');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return strftime($format);
        }
        else if($zone =="NY" || $zone =="ny")
        {
            date_default_timezone_set('America/New_York');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return strftime($format);
        }
        else if($zone =="PTR" || $zone =="ptr")
        {
            date_default_timezone_set('America/Puerto_Rico');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return strftime($format);
        }
        else if($zone =="TOR" || $zone =="tor")
        {
            date_default_timezone_set('America/Toronto');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return strftime($format);
        }
        else
        {
            return "no time zone exists with the command typed";
        }
    }

    function JumpDate($time, $range, $cav)
    {
        $fechas = date("d/m/Y");
        $cadenas = explode("/", $fechas);
        $year = 0;
        $day =0;
        $month = 0;
        $cadena = explode("/",$time);
        $cont=0;
        for($i=0; $i<count($cadena); $i++)
        {
            if($this->Len($cadena[$i])==4)
            {
                $year = $cadena[$i];
            }
            else
            {
                if($cadena[$i] == $cadenas[0])
                {
                    $day = $cadena[$i];
                }
                else if($cadena[$i] == $cadenas[1])
                {
                    $month = $cadena[$i];
                }
            }
        }
        if($cav=="m" && $range<=6)
        {
            $newdate = $month + $range;
            if($newdate>12)
            {
                $newdate=12;
            }
            $fecha = $day."/".$newdate."/".$year;
            return $fecha;
        }
        else if($cav=="d" && $range<=15)
        {
            $newdate = $day + $range;
            if($newdate>31)
            {
                $newdate=31;
            }
            $fecha = $newdate."/".$month."/".$year;
            return $fecha;
        }
        else if($cav=="y")
        {
            $newdate = $year + $range;
            $fecha = $day."/".$month."/".$newdate;
            return $fecha;
        }
        else
        {
            return false;
        }
    }

function Len($cadena)
{
    $arreglo = str_split($cadena);
    $contador =0;
    for($i=0; $i<count($arreglo); $i++)
    {
        $contador+=1;
    }
    return $contador;
}
}
?>
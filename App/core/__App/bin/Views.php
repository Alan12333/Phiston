<?php

/*Esta es pagina de carga del nucleo principal*/
class Views 
{
    public function __construct()
    {

    }

    

    public function View(string $vista, string $title, $params = "")
    {
        
        if($params!="")
        {
            $tupe = gettype($params);
            if($tupe=="string")
            {
                $params2 = json_decode($params);
                if(is_array($params2))
                {
                    $cont = 0;
                    foreach ($params2 as $key)
                    {
                        $cont +=1;
                    }
                    if($cont==1)
                    {
                        foreach ($params2 as $key) 
                        {
                            $style=$vista;
                            $scripts=$vista;
                            $selected="2";
                            require_once('req.php');
                            include('phis.php');
                        }
                    }
                    else
                    {
                        $style=$vista;
                        $scripts=$vista;
                        $selected="2";
                        require_once('req.php');
                        include('phis.php');
                    }
                }
                else
                {
                    $style=$vista;
                    $scripts=$vista;
                    $selected="2";
                    require_once('req.php');
                    include('phis.php');
                }
            }
            else
            {
                $param = $params;
                $style=$vista;
                $scripts=$vista;
                $selected="2";
                require_once('req.php');
                include('phis.php');
            }
        }
        else
        {
            $style=$vista;
            $scripts=$vista;
            $selected="2";
            require_once('req.php');
            include('phis.php');
        }
    }

    public function GetId($optional=1)
    {
        if(isset($_GET['action']))
        {
            $rutas=explode("/",$_GET['action']);
            $arrayroutes = array();
            $numero = count($rutas);
            if($optional==1)
            {
                $numero2 = $rutas[$numero-1];
                return $numero2;
            }
            else 
            {
                $cont =1;
                for($i=count($rutas)-1; $i>=2; $i--)
                {
                    if($cont<=$optional)
                    {
                        array_push($arrayroutes,$rutas[$i]);
                        $cont++;
                    }
                }
            }
            return $arrayroutes;
        }
    }

    
    public function Route($url = "", $properties = [])
    {
        ?>
            <script>
                window.location="<?php echo $url;?>";
            </script>
        <?php
    }

    public function Logout($url)
    {
        session_destroy();
        ?>
            <script>
                window.location="<?php echo $url;?>";
            </script>
        <?php
    }
    
}

?>
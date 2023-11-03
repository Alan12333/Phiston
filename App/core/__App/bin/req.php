<?php

function HeadTitle($Nombre)
{
    echo "\n\t\t\t<title>$Nombre</title>\n";
}



function Script($script)
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    $newscript="\n<script src='".$products['route']."/".$products['ProjectName']."/App/public/render/js.php'></script>\n";
    return $newscript;
}
function Style($style)
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    $newstyle="<link rel='stylesheet' href='".$products['route']."/".$products['ProjectName']."/App/public/render/css.php'>\n\n";
    return $newstyle;
}

function GlobalStyle()
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    $directorio = 'App/public/css';
    $ficheros1  = scandir($directorio);
    for($i=2; $i<count($ficheros1); $i++)
    {
        echo "\n\t\t\t<link rel='stylesheet' href='".$products['route']."/".$products['ProjectName']."/App/public/css/".$ficheros1[$i]."'>";
    }
}


function lang()
{
    $idiomaPreferido = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    $idiomas = explode(',', $idiomaPreferido);
    $idioma = $idiomas[0];
    return  $idioma;
}

?>
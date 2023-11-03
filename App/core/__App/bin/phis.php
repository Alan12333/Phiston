<?php
    $_SESSION['file'] = Checks($vista);
    $_SESSION["folder"] = stamp($vista);
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    include("__scripts/render.php");
?>
        <!DOCTYPE html>
        <html lang="<?php echo lang(); ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="csrf-token" id="csrf-token" content="<?php CSRFVal();?>">
            <?php
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProjectName']."/App/public/icon/".$products['favicon']."' type='image/x-icon'>\n";
            echo " \t\t\t<link rel='apple-touch-icon-precomposed' sizes='144x144' href='".$products['route']."/".$products['ProjectName']."/App/public/icon/".$products['favicon']."'>\n";
            echo " \t\t\t<link rel='shortcut icon' href='".$products['route']."/".$products['ProjectName']."/App/public/icon/".$products['favicon']."'>\n";
        ?>
            <?php echo Style(stamp($vista), Checks($vista));?>
            <?php include (dirname(__FILE__,5)."/dependency.php");?>
            <?php GlobalStyle();?>
            <?php HeadTitle($title)?>
        </head>
            <?php  
                if(file_exists('App/Views/'.stamp($vista).'/'.Checks($vista).'.block.php'))
                {
                    require_once('App/Views/'.stamp($vista).'/'.Checks($vista).'.block.php'); 
                }
                require_once('App/Views/'.stamp($vista).'/'.Checks($vista).'.index.php');
                echo Script(stamp($vista));
            ?>
    <?php
    

function stamp($rute)
{
    $array = explode(".", $rute);
    if(count($array) > 1)
    {
        $files = $array[0]."/".$array[1];
        return $files;
    }
    else
    {
        return $rute;
    }
}

function Checks($rute)
{
    $array = explode(".", $rute);
    if(count($array) > 1)
    {
        $files = $array[1];
        return $files;
    }
    else
    {
        return $rute;
    }
}
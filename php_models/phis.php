<?php
if($propose=="1")
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    
    ?>
            <!DOCTYPE html>
        <html lang="es">
        <head>
        <?php
            echo "<meta name='author' content='".$products['author']."'>";
            echo "<meta name='description' content='".$products['description']."'>";
            echo "<meta property='og:image' content='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['ogimg']."'>";
            echo "<meta property='og:description' content='".$products['ogdes']."'>";
            echo "<meta property='og:title' content='".$products['ogtitle']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."' type='image/x-icon'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='144x144' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='114x114' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='72x72' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
        ?>       
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo HeadTitle($title)?></title>
            <?php echo StylePage($style);?>
            <?php echo GlobalStyle();?>
        </head>
        <body>
            <?php
                try {
                    require_once('Views/app/'.$vista.'.php');
                } catch (Exception $err) {
                    echo $err;
                }
            ?>
        </body>
        <?php
        echo ScriptPage($scripts);
        echo GlobalScript();
        ?>
        </html>
    <?php
}
else if($propose=="2")
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php
            echo "<meta name='author' content='".$products['author']."'>";
            echo "<meta name='description' content='".$products['description']."'>";
            echo "<meta property='og:image' content='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['ogimg']."'>";
            echo "<meta property='og:description' content='".$products['ogdes']."'>";
            echo "<meta property='og:title' content='".$products['ogtitle']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."' type='image/x-icon'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='144x144' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='114x114' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='72x72' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
        ?>   
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo HeadTitle($title)?></title>
            <?php echo Style($style);?>
            <?php GlobalStyle();?>
        </head>


    <?php
    try {
        require_once('Views/'.$vista.'/'.$vista.'.struct.php');   
        require_once('Views/'.$vista.'/'.$vista.'.index.php');
    } catch (Exception $err) {
        echo $err;
    }
    echo Script($scripts);
    GlobalScript();
}
else if($propose=="3")
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    ?>
            <!DOCTYPE html>
        <html lang="es">
        <head>
        <?php
            echo "<meta name='author' content='".$products['author']."'>\n";
            echo "<meta name='description' content='".$products['description']."'>";
            echo "<meta property='og:image' content='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['ogimg']."'>";
            echo "<meta property='og:description' content='".$products['ogdes']."'>";
            echo "<meta property='og:title' content='".$products['ogtitle']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."' type='image/x-icon'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='144x144' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='114x114' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='72x72' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
        ?>          
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo HeadTitle($title)?></title>
        <?php echo Style($style);?>
        <?php  GlobalStyle();?>
    </head>
    <body>
        <?php
            try {
                require_once('Views/'.$vista.'/'.$vista.'.index.php');
            } catch (Exception $err) {
                echo $err;
            }
        ?>
    </body>
    </html>
    <?php
        echo Vuex();
        echo Vue();
        echo Script($scripts);
        GlobalScript();
    ?>
    <?php
}
else if($propose=="4")
{
    $data = file_get_contents("config.json");
    $products = json_decode($data, true);
    
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php
            echo "<meta name='author' content='".$products['author']."'>";
            echo "<meta name='description' content='".$products['description']."'>";
            echo "<meta property='og:image' content='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['ogimg']."'>";
            echo "<meta property='og:description' content='".$products['ogdes']."'>";
            echo "<meta property='og:title' content='".$products['ogtitle']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."' type='image/x-icon'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='144x144' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='114x114' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' sizes='72x72' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='apple-touch-icon-precomposed' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favimg']."'>";
            echo "<link rel='shortcut icon' href='".$products['route']."/".$products['ProyectName']."/public/icon/".$products['favicon']."'>";
        ?>   
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo HeadTitle($title)?></title>
            <?php echo Style($style);?>
            <?php GlobalStyle();?>
        </head>


    <?php
    try {
        require_once('Views/'.$loc.'/'.$vista.'/'.$vista.'.struct.php');   
        require_once('Views/'.$loc.'/'.$vista.'/'.$vista.'.index.php');
    } catch (Exception $err) {
        echo $err;
    }
    echo Script($scripts);
    GlobalScript();
}
?>
<?php
class ThrowException{

    
    public static function setErrorHandler() {
        set_error_handler([self::class, 'handle']);
    }

    public static function restoreErrorHandler() {
        restore_error_handler();
    }

    public static function handle($errno, $errstr, $errfile, $errline) {
        if ($errno === E_ERROR) {
            // Aquí podrías almacenar o manejar el error como desees
            $errorMessage = "Error fatal: $errstr en $errfile en la línea $errline";
            // Por ejemplo, podrías guardar $errorMessage en un archivo de registro
            file_put_contents('errores.log', $errorMessage . PHP_EOL, FILE_APPEND);
            // También podrías enviar correos electrónicos al desarrollador, etc.
        }
    }

    public static function CreateAlert(Error $error)
    {
        $filecontent = file($error->getFile());
        ?>
            <div style="width:100%; background:rgba(0,0,0,0.7); top:0; height:100vh; position:absolute; z-index:10000; font-family:Arial, Helvetica, sans-serif; overflow:hidden;">
                <div style=" width:90%; padding:10px; border-radius:5px;">
                    <p style="font-size: 1em; font-weight:bold; color:#FF3936;">Fatal Error No: <?php echo $error->getCode(); ?></p>
                    <p style="font-size: 1em; font-weight:bold; color:#FF3936;">El error actual se define como <?php echo $error->getMessage(); ?>, se presenta en el archivo <?php echo $error->getFile(); ?> en la linea <?php echo $error->getLine(); ?></p>
                </div>
                <pre style="background: #404040; width: 100%; height:70vh; overflow-y:scroll;">
                    <div style="width: 100%; color:white;">
                        <?php 
                            $lineNumber = 1;
                            foreach($filecontent as $content) {
                                if($lineNumber ===  $error->getLine()) {
                                    print( "<span style='color: red;'>$lineNumber: -->>". htmlspecialchars($content)."</span>");
                                } else {
                                    print( "$lineNumber:". htmlspecialchars($content));
                                }
                                $lineNumber++;
                            }
                        ?>
                    </div>
                </pre>
            </div>
        <?php
    }
}
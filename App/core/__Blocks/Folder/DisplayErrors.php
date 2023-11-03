<?php

class PrintErrors
{
    public static function PrintScreenError($message, $code)
    {
        ?>
            <style><?php include dirname(__FILE__,4)."/public/css/style.css";?></style>
            <body style="background:black; font-family:Arial, Helvetica, sans-serif;">
                <div style="background:rgb(50,50,50); padding:10px;">
                    <p style="font-size:2em; color:red;" >Error: <?php echo $code?></p>
                    <p class="px22  roboto" style="color:cyan;"><?php echo $message?></p>
                </div>
            </body>
        <?php
    }
}
<?php
    session_start();
    header("Content-Type: text/css");
    include("../../core/__App/bin/__scripts/render.php");
    echo Render::TransformCss($_SESSION['folder'], $_SESSION['file']);
?>
<?php
    session_start();
    include("../../core/__App/bin/__scripts/render.php");
    echo Render::TransformjS($_SESSION['folder'], $_SESSION['file']);
?>
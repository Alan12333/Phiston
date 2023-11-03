<?php

class AddRenders
{
    public function CreateColumn($function, $styles="")
    {
        if($styles === "")
        {
            return "
                <td>".$function()."<td>
            ";
        }
        else
        {
            return "
                <td style='$styles'>".$function()."<td>
            ";
        }
    }

    public function CreateBlock($function=null, $styles="")
    {
        return "
            <table style='width:80%; $styles'; align='center'>".
                $function().
            "</table>
        ";
    }

    public function CreateRow($function=null, $styles="")
    {
        return "
                <br>
                    <div style='$styles'>" .$function()." </div>
                <br>
        ";
    }

    public function LinkImage($url="", $url_image="", $width="", $styles="")
    {
        return "
            <a href='$url'><img src='$url_image' width='$width' stye='$styles'></a>
        ";
    }

    public function CreateImage($url, $width="", $height="", $styles="")
    {
        if($width != "" && $height != "")
        {
            return "<img src='$url' width='$width' height='$height' style='$styles'>";
        }
        else if($width != "" && $height =="")
        {
            return "<img src='$url' width='$width' style='$height'>";
        }
        else
        {
            return "<img src='$url' style='$width'>";
        }
    }

    public function CreateTitle($title="", $styles="")
    {
        return "<h1 style='$styles'>$title</h1>";
    }

    public function CreateParr($text="", $styles="")
    {
        return "<p style='$styles'> $text </p><br>";
    }
    public function CreateText($text="", $styles="")
    {
        return "<p style='$styles'> $text </p>";
    }

    public function CreateButton($name, $url, $styles)
    {
        return "
            <table style='width:60%; border-collapse: collapse;' align='center' cellspacing='0' cellpadding='0'>
                <tr>
                    <td style='$styles'>
                        <a href='$url' style='text-decoration:none; color:white;'>
                            <br>
                                $name
                            <br><br>
                        </a>
                    </td>
                </tr>
            </table><br>
        ";
    }

    public function AddHeaders($function, $styles)
    {
        if($styles === "")
        {
            return "
                <th>".$function()."<th>
            ";
        }
        else
        {
            return "
                <th style='$styles'>".$function()."<th>
            ";
        }
    }

    public function CreateBody($html="", $styles="")
    {
        if($styles=="")
        {
            return "
                <body style='font-family:arial;'>
                    <div style='width: 50%; margin:auto; padding:20px'>".
                        $html."
                    </div>
                </body>
            ";
        } else {
            return "
                <head>
                    <link rel='stylesheet' type='text/css' href='$styles'>
                <head>
                <body style='font-family:arial;'>
                    <div style='width: 50%; margin:auto; padding:20px'>".
                        $html."
                    </div>
                </body>
            ";
        }
    }


}
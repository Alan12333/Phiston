<?php
class Letter
{
    private static $abecedary = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','x','y','z'];
    private static $Mayabecedary = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
    private static $caracter = ['*','+','#','%','$','/','?','(',')','!','~','[',']'];
    private static $numbers = ['0','1','2','3','4','5','6','7','8','9'];



    public static function CreatePassword($range=10)
    {
        $array = [];
        $type="pass";
        for($i=0; $i<$range; $i++)
        {
            array_push($array,Letter::GetRandom($range, $type));
        }
        $string = implode("", $array);
        return $string;
    }

    public static function CreateToken()
    {
        $array = [];
        $type="pass";
        for($i=0; $i<22; $i++)
        {
            array_push($array,Letter::GetRandom(12, $type));
        }
        $string = implode("", $array);
        return $string;
    }

    public static function CreateId($range=4)
    {
        $array = [];
        $type="id";
        for($i=0; $i<$range; $i++)
        {
            array_push($array, Letter::GetRandom($range, $type));
        }
        $string = implode("", $array);
        return $string;
    }

    public static function Rands($range=4)
    {
        $array = [];
        for($i=0; $i<$range; $i++)
        {
            array_push($array,rand(0,9));
        }
        $string = implode("", $array);
        return $string;
    }

    public static function GestringId(int $range = 4)
    {
        $array = [];
        
        for($i=0; $i<$range; $i++)
        {
            $random = rand(0,2);
            array_push($array, Letter::GetStringRandom($random));
        }
        $string = implode("", $array);
        return $string;
    }

    private static function GetStringRandom($random)
    {
        $random = rand(0,24);
        if($random==1)
        {
            return self::$abecedary[$random];
        }
        else
        {
            return self::$Mayabecedary[$random];
        }
    }
    private static function GetRandom($range, $type)
    {
        if($type=="pass")
        {
            $random1 = rand(0,3);
        }
        else
        {
            $random1 = rand(0,2);
        }
        $random = rand(0,24);

        switch ($random1) {
            case 0:
                return self::$abecedary[$random];
            case 1:
                return self::$Mayabecedary[$random];
            case 2:
                if($random<10)
                {
                    return self::$numbers[$random];
                }
                else
                {
                    return self::$Mayabecedary[$random];
                }
            case 3:
                if($random<13)
                {
                    return self::$caracter[$random];
                }
                else
                {
                    return self::$abecedary[$random];
                }
        } 
    }
}
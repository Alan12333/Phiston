<?php
class Timer
{

    public static string $startdate = "";
    public static function GetDate($zone = "MX", $format = "Y-m-d")
    {
        if ($zone == "MX" || $zone == "mx") {
            date_default_timezone_set('America/Mexico_City');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return date($format);
        } else if ($zone == "ARG" || $zone == "arg") {
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return date($format);
        } else if ($zone == "BRZ" || $zone == "brz") {
            date_default_timezone_set('America/Sao_Paulo');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return date($format);
        } else if ($zone == "NY" || $zone == "ny") {
            date_default_timezone_set('America/New_York');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return date($format);
        } else if ($zone == "PTR" || $zone == "ptr") {
            date_default_timezone_set('America/Puerto_Rico');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return date($format);
        } else if ($zone == "TOR" || $zone == "tor") {
            date_default_timezone_set('America/Toronto');
            setlocale(LC_TIME, 'es_MX.UTF-8');
            return date($format);
        } else {
            return "no time zone exists with the command typed";
        }
    }

    public static function JumpDate($time, $range, $cav, $key)
    {
        if ($key == "/") {
            $fechas = date("d/m/Y");
            $cadenas = explode("/", $fechas);
            $year = 0;
            $day = 0;
            $month = 0;
            $cadena = explode("/", $time);
            $cont = 0;
            for ($i = 0; $i < count($cadena); $i++) {
                if (Timer::Len($cadena[$i]) == 4) {
                    $year = $cadena[$i];
                } else {
                    if ($cadena[$i] == $cadenas[0]) {
                        $day = $cadena[$i];
                    } else if ($cadena[$i] == $cadenas[1]) {
                        $month = $cadena[$i];
                    }
                }
            }
            if ($cav == "m" && $range <= 6) {
                $newdate = $month + $range;
                if ($newdate > 12) {
                    $newdate = 12;
                }
                $fecha = $day . "/" . $newdate . "/" . $year;
                return $fecha;
            } else if ($cav == "d" && $range <= 15) {
                $newdate = $day + $range;
                if ($newdate > 31) {
                    $newdate = 31;
                }
                $fecha = $newdate . "/" . $month . "/" . $year;
                return $fecha;
            } else if ($cav == "y") {
                $newdate = $year + $range;
                $fecha = $day . "/" . $month . "/" . $newdate;
                return $fecha;
            } else {
                return false;
            }
        } else if ($key == "-") {
            $fechas = date("d-m-Y");
            $cadenas = explode("-", $fechas);
            $year = 0;
            $day = 0;
            $month = 0;
            $cadena = explode("-", $time);
            $cont = 0;
            for ($i = 0; $i < count($cadena); $i++) {
                if (Timer::Len($cadena[$i]) == 4) {
                    $year = $cadena[$i];
                } else {
                    if ($cadena[$i] == $cadenas[0]) {
                        $day = $cadena[$i];
                    } else if ($cadena[$i] == $cadenas[1]) {
                        $month = $cadena[$i];
                    }
                }
            }
            if ($cav == "m" && $range <= 6) {
                $newdate = $month + $range;
                if ($newdate > 12) {
                    $newdate = 12;
                }
                $fecha = $day . "-" . $newdate . "-" . $year;
                return $fecha;
            } else if ($cav == "d" && $range <= 15) {
                $newdate = $day + $range;
                if ($newdate > 31) {
                    $newdate = 31;
                }
                $fecha = $year . "-" . $month . "-" . $newdate;
                return $fecha;
            } else if ($cav == "y") {
                $newdate = $year + $range;
                $fecha = $day . "-" . $month . "-" . $newdate;
                return $fecha;
            } else {
                return false;
            }
        }
    }
    public static function Len($cadena)
    {
        $arreglo = str_split($cadena);
        $contador = 0;
        for ($i = 0; $i < count($arreglo); $i++) {
            $contador += 1;
        }
        return $contador;
    }

    public static function GetMonthName($fecha, $key, $lenguaje)
    {
        if ($key == "/") {
            $cadenas = explode("/", $fecha);
            $position1 = $cadenas[0];
            $position2 = $cadenas[1];
            $position3 = $cadenas[2];
            if (Timer::Len($position2) > 2) {
                return "Position date bad";
            }
            $mont = Timer::Months($position2, $lenguaje);
            $newdate = $position1 . "/" . $mont . "/" . $position3;
            return $newdate;
        } else if ($key == "-") {
            $cadenas = explode("-", $fecha);
            $position1 = $cadenas[0];
            $position2 = $cadenas[1];
            $position3 = $cadenas[2];
            if (Timer::Len($position2) > 2) {
                return "Position date bad";
            }
            $mont = Timer::Months($position2, $lenguaje);
            $newdate = $position1 . "-" . $mont . "-" . $position3;
            return $newdate;
        } else if ($key == ":") {
            $cadenas = explode(":", $fecha);
            $position1 = $cadenas[0];
            $position2 = $cadenas[1];
            $position3 = $cadenas[2];
            if (Timer::Len($position2) > 2) {
                return "Position date bad";
            }
            $mont = Timer::Months($position2, $lenguaje);
            $newdate = $position1 . ":" . $mont . ":" . $position3;
            return $newdate;
        } else if ($key == "~") {
            $cadenas = explode("~", $fecha);
            $position1 = $cadenas[0];
            $position2 = $cadenas[1];
            $position3 = $cadenas[2];
            if (Timer::Len($position2) > 2) {
                return "Position date bad";
            }
            $mont = Timer::Months($position2, $lenguaje);
            $newdate = $position1 . "~" . $mont . "~" . $position3;
            return $newdate;
        }
    }

    private static function Months($time, $lenguaje)
    {
        if ($lenguaje == "es") {
            if ($time == "01") {
                return "Enero";
            } else if ($time == "02") {
                return "Febrero";
            } else if ($time == "03") {
                return "Marzo";
            } else if ($time == "04") {
                return "Abril";
            } else if ($time == "05") {
                return "Mayo";
            } else if ($time == "06") {
                return "Junio";
            } else if ($time == "07") {
                return "Julio";
            } else if ($time == "08") {
                return "Agosto";
            } else if ($time == "09") {
                return "Septiembre";
            } else if ($time == "10") {
                return "Octubre";
            } else if ($time == "11") {
                return "Noviembre";
            } else if ($time == "12") {
                return "Diciembre";
            }
        } else if ($lenguaje == "en") {
            if ($time == "01") {
                return "January";
            } else if ($time == "02") {
                return "February";
            } else if ($time == "03") {
                return "March";
            } else if ($time == "04") {
                return "April";
            } else if ($time == "05") {
                return "May";
            } else if ($time == "06") {
                return "June";
            } else if ($time == "07") {
                return "July";
            } else if ($time == "08") {
                return "August";
            } else if ($time == "09") {
                return "September";
            } else if ($time == "10") {
                return "October";
            } else if ($time == "11") {
                return "November";
            } else if ($time == "12") {
                return "December";
            }
        }
    }

    public static function Range($startdate, $enddate, $type = "D")
    {
        $cadena = explode(Timer::ObtainCaracter($startdate), $startdate);
        $cadena2 = explode(Timer::ObtainCaracter($enddate), $enddate);
        $value = 0;
        if ($type == "d" || $type == "D") {
            if ($cadena[0] > $cadena2[0]) {
                $fecha1 = new DateTime($startdate);
                $fecha2 = new DateTime($enddate);
                $diff = $fecha1->diff($fecha2);
                return -$diff->days;
            } else if ($cadena[0] == $cadena2[0]) {
                if ($cadena[1] > $cadena2[1]) {
                    $fecha1 = new DateTime($startdate);
                    $fecha2 = new DateTime($enddate);
                    $diff = $fecha1->diff($fecha2);
                    return -$diff->days;
                } else if ($cadena[1] == $cadena2[1]) {
                    if ($cadena[2] > $cadena2[2]) {
                        $fecha1 = new DateTime($startdate);
                        $fecha2 = new DateTime($enddate);
                        $diff = $fecha1->diff($fecha2);
                        return -$diff->days;
                    } else {
                        $fecha1 = new DateTime($startdate);
                        $fecha2 = new DateTime($enddate);
                        $diff = $fecha1->diff($fecha2);
                        return $diff->days;
                    }
                } else if ($cadena[1] < $cadena2[1]) {
                    $fecha1 = new DateTime($startdate);
                    $fecha2 = new DateTime($enddate);
                    $diff = $fecha1->diff($fecha2);
                    return $diff->days;
                }
            } else if ($cadena[0] < $cadena2[0]) {
                $fecha1 = new DateTime($startdate);
                $fecha2 = new DateTime($enddate);
                $diff = $fecha1->diff($fecha2);
                return $diff->days;
            }
        }
        if ($type == "m" || $type == "M") {
            if ($cadena[1] == $cadena2[1]) {
                $quest = Timer::EvaluateYears($cadena[0], $cadena2[0]);
                if ($quest == 0) {
                    return $value = 0;
                } else {
                    return 12 * $quest;
                }
            } else if ($cadena[1] < $cadena2[1]) {
                $quest = Timer::EvaluateYears($cadena[0], $cadena2[0]);
                if ($quest > 0) {
                    $quest = $quest * 12;
                    $sum = $quest + Timer::EvaluateMonth($cadena[1], $cadena2[1]);
                    return $sum;
                }
                return Timer::EvaluateMonth($cadena[1], $cadena2[1]);
            } else {
                return "Date 1 can't be bigger than date 2";
            }
        }
        if ($type == "y" || $type == "Y") {
            if ($cadena[0] == $cadena2[0]) {
                $value = 0;
                return $value;
            } else if ($cadena[0] < $cadena2[0]) {
                $value = Timer::EvaluateYears($cadena[0], $cadena2[0]);
                return $value;
            } else {
                return "Date 1 can't be bigger than date 2";
            }
        }
    }
    private static function EvaluateMonth($month1, $month2)
    {
        $evaluate = 0;
        if ($month2 > $month1) {
            $evaluate = $month2 - $month1;
        } else if ($month2 < $month1) {
            $evaluate = $month1 - $month2;
        }
        return $evaluate;
    }

    private static function EvaluateYears($year1, $year2)
    {
        $evaluate = 0;
        if ($year2 > $year1) {
            $evaluate = $year2 - $year1;
            return $evaluate;
        } else if ($year2 < $year1) {
            $evaluate = $year1 - $year2;
            return $evaluate;
        } else {
            $evaluate = 0;
            return $evaluate;
        }
    }


    private static function ObtainCaracter($date)
    {
        $arreglo  = str_split($date);
        $caracter = "";
        for ($i = 0; $i < count($arreglo); $i++) {
            if ($arreglo[$i] == "-" || $arreglo[$i] == "/") {
                $caracter = $arreglo[$i];
            }
        }
        return $caracter;
    }

    public static function AddDays(int $days)
    {
        $date_now = Timer::$startdate;
        $date_future = strtotime($days . ' day', strtotime($date_now));
        $date_future = date('Y-m-d', $date_future);
        return $date_future;
    }
}

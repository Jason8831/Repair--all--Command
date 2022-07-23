<?php

namespace Jason8831\Repair\Manager;

class fonction
{
    public static function convert(int $int, string $color1 = "§4", string $color2 = "§4")
    {
        $day = floor($int / 86400);
        $hourSec = $int % 86400;
        $hour = floor($hourSec / 3600);
        $minuteSec = $hourSec % 3600;
        $minute = floor($minuteSec / 60);
        $remainingSec = $minuteSec % 60;
        $second = ceil($remainingSec);
        if(!isset($day)) $day = 0;
        if (!isset($hour)) $hour = 0;
        if (!isset($minute)) $minute = 0;
        if (!isset($second)) $second = 0;

        return "$color1" . $day . " jour(s)$color2, $color1" . $hour . " heure(s)$color2, $color1" . $minute . " minute(s)$color2 et $color1" . $second . " seconde(s){$color2}";
    }
}
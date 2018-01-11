<?php

class RandomStringHelper extends CApplicationComponent
{
    public static function generate($int = 0, $string = '')
    {
        $key = null;
        for ($i = 0; $i < $int; $i++) {
            $key .= $string[rand(0, strlen($string) - 1)];
        }
        return $key;
    }
}
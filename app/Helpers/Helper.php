<?php
namespace App\Helpers;

class Helper
{
    public static function avatar($name)
    {
        $name_slice = explode(' ',$name);
        $name_slice = array_filter($name_slice);
        $initials = '';
        $initials .= (isset($name_slice[0][0]))?strtoupper($name_slice[0][0]):'';
        $initials .= (isset($name_slice[count($name_slice)-1][0]))?strtoupper($name_slice[count($name_slice)-1][0]):'';
        return $initials;
    }

    public static function imageFileToName($name){
        return str_replace("storage/media/","",$name);
    }
    public static function removeSpecialChar($str) {
        $res = str_replace("_", " ", $str);
        return strtolower($res);
    }
}
<?php

namespace App\Services;

class ZipcodeService
{
    public static function zipcode($zipcode)
    {
        //最初から3文字分を取得する
        $zip1 = substr($zipcode, 0, 3);
        //4文字目から最後まで取得する
        $zip2 = substr($zipcode, 3);
        //ハイフンで結合する
        $zipcode = $zip1 . '-' . $zip2;
        return $zipcode;
    }
}

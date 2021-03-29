<?php

namespace App\Services;

class GetWeatherService
{
    // 天気データ取得メソッド
    public static function getWeather($api_type, $zip)
    {
        $env = config('app.weather');
        $api_base = 'https://api.openweathermap.org/data/2.5/';
        $api_parm = "?zip={$zip},JP&units=metric&appid={$env}";
        $api_url = $api_base . $api_type . $api_parm;

        return json_decode(file_get_contents($api_url), true);
    }
}

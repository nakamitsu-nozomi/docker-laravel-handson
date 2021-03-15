<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    public $fillable = [
        "zipcode",
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo("App\User");
    }
    // 天気説明を日本語に変換
    public static function getTranslation($arg)
    {
        switch ($arg) {
            case 'overcast clouds':
                return 'どんよりした雲';
                break;
            case 'broken clouds':
                return '雲り';
                break;
            case 'scattered clouds':
                return '雲り';
                break;
            case 'few clouds':
                return '雲り';
                break;
            case 'light rain':
                return '小雨';
                break;
            case 'moderate rain':
                return '雨';
                break;
            case 'heavy intensity rain':
                return '大雨';
                break;
            case 'very heavy rain':
                return '激しい大雨';
                break;
            case 'clear sky':
                return '快晴';
                break;
            case 'shower rain':
                return 'にわか雨';
                break;
            case 'light intensity shower rain':
                return '小雨のにわか雨';
                break;
            case 'heavy intensity shower rain':
                return '大雨のにわか雨';
                break;
            case 'thunderstorm':
                return '雷雨';
                break;
            case 'snow':
                return '雪';
                break;
            case 'mist':
                return '靄';
                break;
            case 'tornado':
                return '強風';
                break;
            default:
                return $arg;
        }
    }
    // マジックナンバーの定義
    const TOMORROW_WEATHER_COUNT = 8;

    public static function zipcode($zipcode)
    {
        //最初から3文字分を取得する
        $zip1    = substr($zipcode, 0, 3);
        //4文字目から最後まで取得する
        $zip2    = substr($zipcode, 3);
        //ハイフンで結合する
        $zipcode = $zip1 . "-" . $zip2;
        return $zipcode;
    }

    // 天気データ取得メソッド
    public static function getWeather($api_type, $zip)
    {
        $env = config('app.weather');
        $api_base = 'https://api.openweathermap.org/data/2.5/';
        $api_parm = '?zip=' . $zip . ',JP' . '&units=metric&appid=' . $env;
        $api_url = $api_base . $api_type . $api_parm;

        return json_decode(file_get_contents($api_url), true);
    }
}

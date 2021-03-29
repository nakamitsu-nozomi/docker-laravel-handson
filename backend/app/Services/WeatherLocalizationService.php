<?php

namespace App\Services;

class WeatherLocalizationService
{
    // 天気説明を日本語に変換
    public static function getTranslation(string $arg)
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
}

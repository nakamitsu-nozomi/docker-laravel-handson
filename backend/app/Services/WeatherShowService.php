<?php

namespace App\Services;

use Datetime;
use DateTimeZone;

class WeatherShowService
{
    private $weatherLocaliationService;
    private $zipcodeService;
    private $getWeatherService;

    public function __construct(
        weatherLocalizationService $weather_localization_service,
        ZipcodeService $zipcode_service,
        GetWeatherService $get_weather_service
    ) {
        $this->weatherLocalizationService = $weather_localization_service;
        $this->zipcodeService = $zipcode_service;
        $this->getWeatherService = $get_weather_service;
    }

    public function getWeather($user, $location)
    {
        $weathers = [];
        $temp_maxs = [];
        $temp_mins = [];
        $weather_icons = [];
        $dates = [];
        $times = [];
        $tomorrow = new DateTime('+1 day');
        $tomorrow = $tomorrow->format('Y年m月d日');
        $zipcode = $this->zipcodeService->zipcode($location->zipcode);
        $response = $this->getWeatherService->getWeather('forecast', $zipcode);

        $weather_list = $response['list'];

        foreach ($weather_list as $items) {
            array_push($weathers, $this->weatherLocalizationService->getTranslation($items['weather'][0]['description']));
            array_push($temp_maxs, $items['main']['temp_max']); // 最高気温
      array_push($temp_mins, $items['main']['temp_min']); // 最低気温
      array_push($weather_icons, $items['weather'][0]['icon']); // 天気マーク
      $datetime = new DateTime();
            $datetime->setTimestamp($items['dt'])->setTimeZone(new DateTimeZone('Asia/Tokyo')); // 日時 - 協定世界時 (UTC)を日本標準時 (JST)に変換
      array_push($dates, $datetime->format('Y年m月d日')); // 日付
      array_push($times, $datetime->format('H:i')); // 時間
        }
        return view('locations.show', compact('temp_maxs', 'user', 'weathers', 'temp_mins', 'weather_icons', 'dates', 'times', 'tomorrow', 'location'));
    }
}

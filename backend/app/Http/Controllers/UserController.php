<?php

namespace App\Http\Controllers;

use \Datetime;
use \DateTimeZone;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{


    public function show(Request $request, string $name)
    {

        // ユーザーの表示
        $user = User::where("name", $name)->first();
        $locations = $user->locations->sortByDesc("created_at");
        if (Auth::id() === $user->id) {
            $weathers = [];
            $temp_maxs = [];
            $temp_mins = [];
            $weather_icons = [];
            $dates = [];
            $times = [];
            foreach ($locations  as $location) {
                $zipcode = User::zipcode($location->zipcode);
                $response = User::getWeather('forecast', $zipcode);
                $weather_list = $response["list"];
                foreach ($weather_list as $items) {
                    array_push($weathers, User::getTranslation($items['weather'][0]['description'])); // 天気
                    array_push($temp_maxs, $items['main']['temp_max']); // 最高気温
                    array_push($temp_mins, $items['main']['temp_min']); // 最低気温
                    array_push($weather_icons, $items['weather'][0]['icon']); // 天気マーク
                    $datetime = new DateTime();
                    $datetime->setTimestamp($items['dt'])->setTimeZone(new DateTimeZone('Asia/Tokyo')); // 日時 - 協定世界時 (UTC)を日本標準時 (JST)に変換
                    array_push($dates, $datetime->format('Y年m月d日')); // 日付
                    array_push($times, $datetime->format('H:i')); // 時間

                }
            }

            // for ($s = 0; $s < count($locations); $s++) {
            //     $output[] = array($weathers[$s], $temp_maxs[$s], $temp_mins[$s], $weather_icons[$s]);
            //     $outputs[] = array($weathers[$s], $temp_maxs[$s], $temp_mins[$s], $weather_icons[$s], $locations_[$s]);
            // }




            // $datetime = new DateTime();
            // $datetime->setTimestamp($response['dt'])->setTimeZone(new DateTimeZone('Asia/Tokyo')); // 日時 - 協定世界時 (UTC)を日本標準時 (JST)に変換
            // $date =  $datetime->format('Y年m月d日'); //日付
            // $time = $datetime->format('H:i'); // 時間




            return view("users.show", compact("temp_maxs", "user", "weathers", "temp_mins", "weather_icons", "locations", "dates", "times"));
        } else {
            return redirect()->route("users.show", ["name" => $request->user()->name]);
        }
    }
}


// $locations = $user->locations->sortByDesc("created_at");
// $weathers = [];
// $temp_maxs = [];
// $temp_mins = [];
// $weather_icons = [];
// foreach ($locations as $location) {
//     $zipcode = User::zipcode($location->zipcode);
//     $response = User::getWeather('weather', $zipcode);
//     array_push($weathers, User::getTranslation($response['weather'][0]['description'])); // 天気
//     array_push($temp_maxs, $response['main']['temp_max']); // 最高気温
//     array_push($temp_mins, $response['main']['temp_min']); // 最低気温
//     array_push($weather_icons, $response['weather'][0]['icon']); // 天気マーク
// }
// for ($s = 0; $s < count($locations); $s++) {
//     $output[] = array($weathers[$s], $temp_maxs[$s], $temp_mins[$s], $weather_icons[$s]);
//     $outputs[] = array($weathers[$s], $temp_maxs[$s], $temp_mins[$s], $weather_icons[$s], $locations[$s]);
// }


// $datetime = new DateTime();
// $datetime->setTimestamp($response['dt'])->setTimeZone(new DateTimeZone('Asia/Tokyo')); // 日時 - 協定世界時 (UTC)を日本標準時 (JST)に変換
// $date =  $datetime->format('Y年m月d日'); //日付
// $time = $datetime->format('H:i'); // 時間
// return view("users.show", compact("locations", "user", "outputs", "date"));




// $data = [];
// foreach ($locations as $location) {
//     $zipcode = User::zipcode($location->zipcode);
//     $response = User::getWeather('forecast', $zipcode);
//     array_push($data, $response["list"]);
//     // foreach ($weather_list as $items) :
//     //     $temp = $items['main']['temp']; // 気温
//     //     $temp_max = $items['main']['temp_max']; // 最高気温
//     //     $temp_min = $items['main']['temp_min']; // 最低気温
//     //     $humidity = $items['main']['humidity']; // 湿度
//     //     $weather = $items['weather'][0]['main']; // 天気

//     //     // $weather_icon = $items['weather'][0]['icon']; // 天気アイコン（公式のアイコンを使用）
//     //     $datetime = new DateTime();
//     //     $datetime->setTimestamp($items['dt'])->setTimeZone(new DateTimeZone('Asia/Tokyo')); // 日時 - 協定世界時 (UTC)を日本標準時 (JST)に変換
//     //     $date =  $datetime->format('Y年m月d日'); //　日付
//     //     $time = $datetime->format('H:i'); // 時間

//     // endforeach;

// }

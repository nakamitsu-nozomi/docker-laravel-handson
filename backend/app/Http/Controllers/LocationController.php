<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest as RequestsLocationRequest;
use Illuminate\Http\Request;
use App\Http\Requests\LocationRequest;
use App\Location;
use App\PostalCode;
use App\User;
use \Datetime;
use \DateTimeZone;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;


class LocationController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(location::class, "location");
    }
    public function create()
    {
        return view("locations/create");
    }
    public function store(LocationRequest $request)
    {
        $location = new Location();
        $location->fill($request->all());
        $location->zipcode = $request->zipcode;
        $location->address = $request->addr11;
        $location->user_id = $request->user()->id;
        $zipcode = $location->zipcode;
        $first_code   = intval(substr($zipcode, 0, 3));
        $last_code   = intval(substr($zipcode, 3));
        $a = PostalCode::whereSearch($first_code, $last_code)->first();
        if ($a === null) {
            $error[] = "この郵便番号は実在しません";
            return redirect('locations/create')->withInput()->withErrors($error);
        } else {

            $location->save();
            return redirect()->route("users.show", ["name" => $request->user()->name]);
        }
    }

    public function edit(Location $location)
    {
        return view('locations.edit', ['location' => $location]);
    }
    public function update(Request $request, Location $location)
    {

        $location->fill($request->all());
        $location->zipcode = $request->zipcode;
        $location->address = $request->addr11;
        $location->user_id = $request->user()->id;
        $zipcode = $location->zipcode;
        $first_code   = intval(substr($zipcode, 0, 3));
        $last_code   = intval(substr($zipcode, 3));
        $a = PostalCode::whereSearch($first_code, $last_code)->first();
        if ($a === null) {
            $error[] = "この郵便番号は実在しません";
            return redirect('locations/create')->withInput()->withErrors($error);
        } else {

            $location->fill($request->all())->save();
            return redirect()->route("users.show", ["name" => $request->user()->name]);
        }
    }
    public function destroy(Request $request, Location $location)
    {
        $location->delete();
        return redirect()->route("users.show", ["name" => $request->user()->name]);
    }
    public function show(Request $request, Location $location)
    {
        // ユーザーの表示
        $user = User::where("id", $location->user_id)->first();
        $weathers = [];
        $temp_maxs = [];
        $temp_mins = [];
        $weather_icons = [];
        $dates = [];
        $times = [];
        $tomorrow = new DateTime('+1 day');
        $tomorrow = $tomorrow->format('Y年m月d日');
        $zipcode = Location::zipcode($location->zipcode);
        try {

            // 例外が発生するおそれがあるコード
            $response = Location::getWeather('forecast', $zipcode);

            $weather_list = $response["list"];
            foreach ($weather_list as $items) {
                array_push($weathers, Location::getTranslation($items['weather'][0]['description'])); // 天気
                array_push($temp_maxs, $items['main']['temp_max']); // 最高気温
                array_push($temp_mins, $items['main']['temp_min']); // 最低気温
                array_push($weather_icons, $items['weather'][0]['icon']); // 天気マーク
                $datetime = new DateTime();
                $datetime->setTimestamp($items['dt'])->setTimeZone(new DateTimeZone('Asia/Tokyo')); // 日時 - 協定世界時 (UTC)を日本標準時 (JST)に変換
                array_push($dates, $datetime->format('Y年m月d日')); // 日付
                array_push($times, $datetime->format('H:i')); // 時間

            }

            return view("locations.show", compact("temp_maxs", "user", "weathers", "temp_mins", "weather_icons", "dates", "times", "tomorrow",  "location"));
        } catch (Exception $e) {
            // 例外発生時の処理
            $error[] = "システムの都合上、この位置情報の天気を取得できません。大変申し訳ありません。";
            return redirect()->route("users.show", ["name" => $request->user()->name])->withInput()->withErrors($error);
        }
    }
}

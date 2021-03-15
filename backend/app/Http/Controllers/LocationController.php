<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest as RequestsLocationRequest;
use Illuminate\Http\Request;
use App\http\Requests\LocationRequest;
use App\Location;
use App\User;
use \Datetime;
use \DateTimeZone;
use Illuminate\Support\Facades\Auth;

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
    public function store(LocationRequest $request, Location $location)
    {
        $location->fill($request->all());
        $location->user_id = $request->user()->id;
        $location->save();
        return redirect()->route("users.show", ["name" => $request->user()->name]);
    }

    public function edit(Location $location)
    {
        return view('locations.edit', ['location' => $location]);
    }
    public function update(Request $request, Location $location)
    {
        $location->fill($request->all())->save();
        return redirect()->route("users.show", ["name" => $request->user()->name]);
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
    }
}

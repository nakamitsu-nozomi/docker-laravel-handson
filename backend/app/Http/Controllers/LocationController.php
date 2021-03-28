<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Location;
use App\PostalCode;
use App\Services\WeatherShowService;
use App\User;
use Exception;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $weatherShowService;

    public function __construct(weatherShowService $weather_show_service)
    {
        $this->weatherShowService = $weather_show_service;
        $this->authorizeResource(location::class, 'location');
    }

    public function create()
    {
        return view('locations/create');
    }

    public function store(LocationRequest $request)
    {
        $location = new Location();
        $location->fill($request->all());
        $location->zipcode = $request->zipcode;
        $location->address = $request->addr11;
        $location->user_id = $request->user()->id;
        $zipcode = $location->zipcode;
        $first_code = intval(substr($zipcode, 0, 3));
        $last_code = intval(substr($zipcode, 3));
        $a = PostalCode::whereSearch($first_code, $last_code)->first();

        if ($a === null) {
            $error[] = 'この郵便番号は実在しません';
            return redirect('locations/create')->withInput()->withErrors($error);
        }

        $location->save();
        return redirect()->route('users.show', ['name' => $request->user()->name]);
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
        $first_code = intval(substr($zipcode, 0, 3));
        $last_code = intval(substr($zipcode, 3));
        $a = PostalCode::whereSearch($first_code, $last_code)->first();

        if ($a === null) {
            $error[] = 'この郵便番号は実在しません';
            return redirect('locations/create')->withInput()->withErrors($error);
        }

        $location->fill($request->all())->save();
        return redirect()->route('users.show', ['name' => $request->user()->name]);
    }

    public function destroy(Request $request, Location $location)
    {
        $location->delete();
        return redirect()->route('users.show', ['name' => $request->user()->name]);
    }

    public function show(Request $request, Location $location)
    {
        // ユーザーの表示
        $user = User::where('id', $location->user_id)->first();
        //天気の表示
        try {
            return  $this->weatherShowService->getWeather($user, $location);
        } catch (Exception $e) {
            $error[] = 'システムの都合上、この位置情報の天気を取得できません。大変申し訳ありません。';
            return redirect()->route('users.show', ['name' => $request->user()->name])->withInput()->withErrors($error);
        }
    }
}

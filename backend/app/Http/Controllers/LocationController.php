<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest as RequestsLocationRequest;
use Illuminate\Http\Request;
use App\http\Requests\LocationRequest;
use App\Location;

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
}

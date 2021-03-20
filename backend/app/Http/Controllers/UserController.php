<?php

namespace App\Http\Controllers;

use App\Location;
use \Datetime;
use \DateTimeZone;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{


    public function show(Request $request, string $name)
    {

        $user = User::where("name", $name)->first();
        if (Auth::id() === $user->id) {

            $locations = $user->locations()->paginate(5);
            $locations->sortByDesc("created_at");

            $temps = [];
            return view("users.show", compact("locations", "user"));
        } else {
            return redirect()->route("users.show", ["name" => $request->user()->name]);
        }
    }
}

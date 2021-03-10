<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, string $name)
    {
        $user = User::where("name", $name)->first();
        $locations = $user->locations->sortByDesc("created_at");
        return view("users.show", compact("locations", "user"));
    }
}

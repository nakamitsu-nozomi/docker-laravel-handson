<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $zipcode = 123456;
        return view("locations/index", compact("zipcode"));
    }
}
<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserDataAccessRepositoryInterface as UserDataAccess;

class UserController extends Controller
{
    protected $userService;

    public function __construct(
        UserService $user_service,
        UserDataAccess $UserDataAcsess
    ) {
        $this->userService = $user_service;
        $this->middleware('auth');
        $this->User = $UserDataAcsess;
    }

    public function show(Request $request, string $name)
    {
        $user = $this->User->getUser($request->name);
        if (Auth::id() === $user->id) {
            $locations = $this->userService->getLocation($user);
            return view('users.show', compact('locations', 'user'));
        }
        return redirect()->route('users.show', ['name' => $request->user()->name]);
    }
}

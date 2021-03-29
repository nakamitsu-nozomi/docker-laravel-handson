<?php

namespace App\Repositories\User;

use App\User;
use Illuminate\Http\Request;

class UserDataAccessEQRepository implements UserDataAccessRepositoryInterface
{
  public function getUser(string $name)
  {
    return User::where('name', $name)->first();
  }
}

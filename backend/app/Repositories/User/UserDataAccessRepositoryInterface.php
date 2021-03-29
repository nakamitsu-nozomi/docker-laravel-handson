<?php

namespace App\Repositories\User;

use Illuminate\Http\Request;

interface UserDataAccessRepositoryInterface
{
  public function getUser(string $name);
}

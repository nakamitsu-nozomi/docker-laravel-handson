<?php

namespace App\Services;

class UserService
{
    public function getLocation($user)
    {
        $locations = $user->locations()->paginate(5);
        $locations->sortByDesc('created_at');
        return $locations;
    }
}

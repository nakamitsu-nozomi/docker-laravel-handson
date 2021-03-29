<?php

namespace App\Repositories\User;

interface UserDataAccessRepositoryInterface
{
    public function getUser(string $name);
}

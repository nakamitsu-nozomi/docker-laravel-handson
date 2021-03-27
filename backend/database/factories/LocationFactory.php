<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\User;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'zipcode' => $faker->postcode,
        'address' => $faker->address,
        'user_id' => function () {
            return factory(User::class);
        },
    ];
});

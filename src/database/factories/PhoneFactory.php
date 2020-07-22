<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Phone;
use App\Models\PhoneType;
use Faker\Generator as Faker;

$factory->define(Phone::class, function (Faker $faker) {
    return [
        'number' => rand(10000000000,9999999999999999),
        'type_id' => PhoneType::ORDER,
    ];
});

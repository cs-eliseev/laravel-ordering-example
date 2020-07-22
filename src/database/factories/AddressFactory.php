<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\AddressType;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'full' => $faker->text(255),
        'type_id' => AddressType::ORDER,
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\Client;
use App\Models\Phone;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'address_id' => function () {
            return factory(Address::class)->create()->id;
        },
        'phone_id' => function () {
            return factory(Phone::class)->create()->id;
        },
    ];
});

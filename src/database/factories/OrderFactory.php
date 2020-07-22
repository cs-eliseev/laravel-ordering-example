<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use App\Models\Order;
use App\Models\Package;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $package = Package::all()->random();

    $delivery = Carbon::create(rand(2015, 2020),rand(1, 12) ,rand(1, 28) , 0, 0, 0);

    return [
        'name' => $faker->name,
        'address_id' => function () {
            return factory(Address::class)->create()->id;
        },
        'price' => $package->price,
        'package_id' => $package->id,
        'delivery_at' => $delivery,
    ];
});

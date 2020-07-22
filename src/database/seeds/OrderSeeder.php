<?php

use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderSeeder
 *
 * @description Генерация заказов.
 */
class OrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            factory(Client::class, rand(20, 40))->create()->each(function(Client $client) {
                $client->orders()->saveMany(factory(Order::class, rand(10, 40))->make());
            });
        });

    }
}

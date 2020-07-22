<?php

use App\Helpers\EnvHelpers;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!EnvHelpers::isProduction()) {
            $this->call(PackageSeeder::class);
            $this->call(OrderSeeder::class);
        }
    }
}

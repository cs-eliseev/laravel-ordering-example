<?php

declare(strict_types=1);

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
    public function run(): void
    {
        if (!EnvHelpers::isProduction()) {
            $this->call(PackageSeeder::class);
            $this->call(OrderSeeder::class);
        }
    }
}

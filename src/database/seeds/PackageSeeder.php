<?php

declare(strict_types=1);

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PackageSeeder
 *
 * @description Генерируем новые тарифы.
 */
class PackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // Количество записей
            $cntRender = rand(7, 20);
            $days = \App\Models\Day::query()->get()->toArray();
            while ($cntRender != 0) {
                $package = new \App\Models\Package();
                $package->name = 'Тариф' . rand(1, 999999);
                $package->price = rand(1, 2000);
                $package->save();

                // Список дней недели по тарифному плану
                $cntWeakDay = rand(1, 7);

                $dayList = $days;
                while ($cntWeakDay != 0) {
                    $pacageDay = new \App\Models\PackageDay();
                    $pacageDay->package()->associate($package);
                    $keyDay = array_rand($dayList);
                    $pacageDay->day_id = $dayList[$keyDay]['id'];
                    $pacageDay->save();
                    unset($dayList[$keyDay]);
                    $cntWeakDay--;
                }
                $cntRender--;
            }
        });
    }
}

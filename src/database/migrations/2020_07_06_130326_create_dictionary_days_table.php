<?php

use App\Models\Day;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDictionaryDaysTable extends Migration
{
    protected $table = 'dictionary_days';

    protected $insertData = [
        [
            'id' => Day::MONDAY,
            'name' => 'Понедельник',
        ],
        [
            'id' => Day::TUESDAY,
            'name' => 'Вторник',
        ],
        [
            'id' => Day::WEDNESDAY,
            'name' => 'Среда',
        ],
        [
            'id' => Day::THURSDAY,
            'name' => 'Четверг',
        ],
        [
            'id' => Day::FRIDAY,
            'name' => 'Пятница',
        ],
        [
            'id' => Day::SATURDAY,
            'name' => 'Суббота',
        ],
        [
            'id' => Day::SUNDAY,
            'name' => 'Воскресенье',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::create($this->table, function (Blueprint $table) {
                $table->increments('id');
                $table->string('name', 11)->comment('День недели');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            });

            DB::table($this->table)->insert($this->insertData);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}

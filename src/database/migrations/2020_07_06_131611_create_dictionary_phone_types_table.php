<?php

use App\Models\PhoneType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDictionaryPhoneTypesTable extends Migration
{
    protected $table = 'dictionary_phone_types';

    protected $insertData = [
        [
            'id' => PhoneType::CELL,
            'name' => 'Сотовый',
        ],
        [
            'id' => PhoneType::HOME,
            'name' => 'Домашний',
        ],
        [
            'id' => PhoneType::ORDER,
            'name' => 'Заказ',
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
                $table->string('name', 16)->comment('Тип телефона');
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

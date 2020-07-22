<?php

use App\Models\AddressType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDictionaryAddressTypesTable extends Migration
{
    protected $table = 'dictionary_address_types';

    protected $insertData = [
        [
            'id' => AddressType::CLIENT,
            'name' => 'Клиент',
        ],
        [
            'id' => AddressType::ORDER,
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
                $table->string('name', 16)->comment('Тип адреса');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    protected $table = 'orders';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->comment('Имя полуателя');
            $table->unsignedBigInteger('package_id')->comment('Тариф');
            $table->decimal('price', 10, 2)->comment('Стоимость заказа');
            $table->unsignedBigInteger('client_id')->comment('Клиент');
            $table->unsignedBigInteger('address_id')->comment('Адрес доставки');
            $table->timestamp('delivery_at')->comment('Дата доставки');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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

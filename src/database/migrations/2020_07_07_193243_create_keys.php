<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            Schema::table('clients', function (Blueprint $table) {
                $table->foreign('address_id')->references('id')->on('addresses')
                    ->onDelete('restrict')->onUpdate('restrict');
                $table->foreign('phone_id')->references('id')->on('phones')
                    ->onDelete('restrict')->onUpdate('restrict');
            });
            Schema::table('addresses', function (Blueprint $table) {
                $table->foreign('type_id')->references('id')->on('dictionary_address_types')
                    ->onDelete('restrict')->onUpdate('restrict');
            });
            Schema::table('phones', function (Blueprint $table) {
                $table->foreign('type_id')->references('id')->on('dictionary_phone_types')
                    ->onDelete('restrict')->onUpdate('restrict');
                $table->index('number', 'number_index');
            });
            Schema::table('packages_days', function (Blueprint $table) {
                $table->foreign('package_id')->references('id')->on('packages')
                    ->onDelete('restrict')->onUpdate('restrict');
                $table->foreign('day_id')->references('id')->on('dictionary_days')
                    ->onDelete('restrict')->onUpdate('restrict');
            });
            Schema::table('orders', function (Blueprint $table) {
                $table->foreign('address_id')->references('id')->on('addresses')
                    ->onDelete('restrict')->onUpdate('restrict');
                $table->foreign('client_id')->references('id')->on('clients')
                    ->onDelete('restrict')->onUpdate('restrict');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::transaction(function () {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropForeign(['address_id']);
                $table->dropForeign(['phone_id']);
            });
            Schema::table('addresses', function (Blueprint $table) {
                $table->dropForeign(['type_id']);
            });
            Schema::table('phones', function (Blueprint $table) {
                $table->dropForeign(['type_id']);
                $table->dropIndex('number_index');
            });
            Schema::table('packages_days', function (Blueprint $table) {
                $table->dropForeign(['package_id']);
                $table->dropForeign(['day_id']);
            });
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['address_id']);
                $table->dropForeign(['clients_id']);
            });
        });
    }
}

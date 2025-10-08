<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_user_cards', function (Blueprint $table) {
            // Удаляем внешний ключ
            $table->dropForeign(['order_id']);
        });

        // Делаем поле nullable через raw SQL — для PostgreSQL это самый надёжный способ
        DB::statement('ALTER TABLE product_user_cards ALTER COLUMN order_id DROP NOT NULL');

        Schema::table('product_user_cards', function (Blueprint $table) {
            // Добавляем обратно внешний ключ
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    public function down(): void
    {
        Schema::table('product_user_cards', function (Blueprint $table) {
            // Удаляем внешний ключ
            $table->dropForeign(['order_id']);
        });

        // Делаем поле обратно NOT NULL
        DB::statement('ALTER TABLE product_user_cards ALTER COLUMN order_id SET NOT NULL');

        Schema::table('product_user_cards', function (Blueprint $table) {
            // Добавляем обратно внешний ключ
            $table->foreign('order_id')->references('id')->on('orders');
        });
    }
};

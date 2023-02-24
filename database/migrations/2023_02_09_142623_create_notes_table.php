<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("order_id");
            $table->text("content");

            // 🔹 costumer_note = یادداشتی که مشتری در سفارشش ثبت میکنه
            // 🔹 order_note = بخش یادداشت های ووکامرس برای هر سفارش که نوع خصوصی و پابلیک داره و خودمون اضافه میکنیم یا افزونه ها اضافه میکنن
            $table->enum("type", ['order', 'customer']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('notes');
    }
};

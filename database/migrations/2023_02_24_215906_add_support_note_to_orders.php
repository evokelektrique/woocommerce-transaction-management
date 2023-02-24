<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // 🔹 support_note= این فقط یادداشتی هست که ما توی لاراول مینویسیم و برای نشون دادن وضعیت سفارش هامون ازش کمک میگیریم و نیازی هم نیست توی وردپرس ثبت بشه
            $table->text("support_note")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("support_note");
        });
    }
};

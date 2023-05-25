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
        Schema::table('notes', function (Blueprint $table) {
            $table->boolean("customer_note")->default(false);
            $table->timestamp("date_created_gmt")->nullable();
            $table->string("author")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn("customer_note");
            $table->dropColumn("date_created_gmt");
            $table->dropColumn("author");
        });
    }
};

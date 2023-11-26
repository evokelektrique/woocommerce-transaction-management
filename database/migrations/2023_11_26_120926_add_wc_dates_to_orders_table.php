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
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp("wc_created_at")->nullable();
            $table->timestamp("wc_modified_at")->nullable();
            $table->timestamp("wc_paid_at")->nullable();
            $table->timestamp("wc_completed_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn("wc_created_at");
            $table->dropColumn("wc_modified_at");
            $table->dropColumn("wc_paid_at");
            $table->dropColumn("wc_completed_at");
        });
    }
};

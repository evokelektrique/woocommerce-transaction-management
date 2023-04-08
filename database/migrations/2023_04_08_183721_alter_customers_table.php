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
        Schema::table('customers', function (Blueprint $table) {
            $table->string("email")->nullable()->change();
            $table->string("first_name")->nullable()->change();
            $table->string("last_name")->nullable()->change();
            $table->string("phone")->nullable()->change();
            $table->string("username")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('customers', function (Blueprint $table) {
            $table->string("email")->change();
            $table->string("first_name")->change();
            $table->string("last_name")->change();
            $table->string("phone")->change();
            $table->string("username")->change();
        });
    }
};

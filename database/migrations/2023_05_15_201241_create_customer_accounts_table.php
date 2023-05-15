<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('customer_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->timestamp("date")->nullable();
            $table->string("email")->nullable();
            $table->string("title")->nullable();
            $table->string("username")->nullable();
            $table->string("password")->nullable();
            $table->string("code")->nullable();
            $table->integer("expire_days")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('customer_accounts');
    }
};

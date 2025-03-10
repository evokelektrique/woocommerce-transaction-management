<?php

use App\Models\Order;
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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained();
            $table->timestamp("date")->nullable()->comment("Account create date");
            $table->string("email")->nullable();
            $table->string("title")->nullable();
            $table->string("username")->nullable();
            $table->string("password")->nullable();
            $table->string("code")->nullable();
            $table->integer("expire_days")->nullable()->comment("Number of days after account expires");
            $table->timestamp("expire_at")->nullable()->comment("Account will be expired at");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('accounts');
    }
};

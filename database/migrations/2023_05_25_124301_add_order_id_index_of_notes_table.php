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
        Schema::table("notes", function (Blueprint $table) {
            $table->foreignIdFor(Order::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table("notes", function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(Order::class);
        });
    }
};

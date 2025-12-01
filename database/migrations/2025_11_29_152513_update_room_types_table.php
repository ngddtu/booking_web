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
        Schema::table('room_types', function (Blueprint $table) {
            // $table->dropColumn('price');
            // $table->integer('max_people');
            // $table->integer('type');
            // $table->decimal('initial_hour_rate', 10, 2);
            // $table->decimal('overnight_rate', 10, 2);
            // $table->decimal('daily_rate', 10, 2);
            // $table->decimal('late_checkout_fee_value', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

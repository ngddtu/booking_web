<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('initial_hour_rate', 10, 2);
            $table->decimal('overnight_rate', 10, 2);
            $table->decimal('daily_rate', 10, 2);
            $table->decimal('late_checkout_fee_value', 10, 2)->default(0);
            $table->integer('max_people');
            $table->enum('status', ['available', 'disable'])->default('available');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('room_types');
    }
};

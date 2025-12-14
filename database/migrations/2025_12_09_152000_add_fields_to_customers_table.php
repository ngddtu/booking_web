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
        Schema::table('customers', function (Blueprint $table) {
            // $table->string('citizen_id')->nullable()->after('phone');
            $table->date('birthday')->nullable();
            // $table->string('nationality')->default('Việt Nam')->nullable()->after('birthday');
            $table->string('rank')->default('normal'); // normal, vip, blacklist
            $table->text('note')->nullable();
            $table->string('gender')->nullable()->after('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn(['citizen_id', 'birthday', 'nationality', 'rank', 'note', 'gender']);
        });
    }
};

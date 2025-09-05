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
        Schema::table('rumah_sakit', function (Blueprint $table) {
            $table->integer('7004')->nullable()->comment('Field untuk pengamanan radiasi tambahan');
            $table->integer('7005')->nullable()->comment('Field untuk pengamanan radiasi tambahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah_sakit', function (Blueprint $table) {
            $table->dropColumn(['7004', '7005']);
        });
    }
};

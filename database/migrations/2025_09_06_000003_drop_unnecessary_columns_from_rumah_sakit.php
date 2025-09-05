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
            // Drop unnecessary columns, keep only 1002a, 1002b, 1002c
            $table->dropColumn([
                '1002a_selected_id',
                '1002b_selected_id', 
                '1002c_selected_id',
                'keterangan_sumber_air',
                '1002',
                '1002_selected_id',
                'keterangan_tangki_air'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Restore dropped columns
            $table->integer('1002a_selected_id')->nullable();
            $table->integer('1002b_selected_id')->nullable();
            $table->integer('1002c_selected_id')->nullable();
            $table->text('keterangan_sumber_air')->nullable();
            $table->integer('1002')->nullable();
            $table->varchar('1002_selected_id', 255)->nullable();
            $table->text('keterangan_tangki_air')->nullable();
        });
    }
};
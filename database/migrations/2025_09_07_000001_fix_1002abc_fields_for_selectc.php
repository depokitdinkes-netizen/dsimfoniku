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
            // Change 1002a, 1002b, 1002c from enum to integer to support Form::selectc
            if (Schema::hasColumn('rumah_sakit', '1002a')) {
                $table->integer('1002a')->nullable()->default(0)->change();
            }
            if (Schema::hasColumn('rumah_sakit', '1002b')) {
                $table->integer('1002b')->nullable()->default(0)->change();
            }
            if (Schema::hasColumn('rumah_sakit', '1002c')) {
                $table->integer('1002c')->nullable()->default(0)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Revert back to enum
            if (Schema::hasColumn('rumah_sakit', '1002a')) {
                $table->enum('1002a', [0, 400])->default(0)->change();
            }
            if (Schema::hasColumn('rumah_sakit', '1002b')) {
                $table->enum('1002b', [0, 400])->default(0)->change();
            }
            if (Schema::hasColumn('rumah_sakit', '1002c')) {
                $table->enum('1002c', [0, 100])->default(0)->change();
            }
        });
    }
};
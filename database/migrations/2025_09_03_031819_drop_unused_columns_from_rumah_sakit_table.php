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
            // Drop kolom yang tidak digunakan
            $table->dropColumn([
                'alasan-tps-b3',
                'alasan-ipal',
                'status-sikelim',
                'status-dsmiling'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Kembalikan kolom yang dihapus jika rollback
            $table->text('alasan-tps-b3')->nullable()->after('nomor-dokumen-rintek-tps-b3');
            $table->text('alasan-ipal')->nullable()->after('nomor-dokumen-pertek-ipal');
            $table->text('status-sikelim')->nullable()->after('pengisian-sikelim');
            $table->text('status-dsmiling')->nullable()->after('pengisian-dsmiling');
        });
    }
};

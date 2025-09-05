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
            // Dokumen dan sistem tracking fields
            $table->enum('dokumen-rintek-tps-b3', ['Ya', 'Tidak'])->nullable()->after('rencana-tindak-lanjut');
            $table->string('nomor-dokumen-rintek-tps-b3')->nullable()->after('dokumen-rintek-tps-b3');
            $table->text('alasan-tps-b3')->nullable()->after('nomor-dokumen-rintek-tps-b3');
            
            $table->enum('dokumen-pertek-ipal', ['Ya', 'Tidak'])->nullable()->after('alasan-tps-b3');
            $table->string('nomor-dokumen-pertek-ipal')->nullable()->after('dokumen-pertek-ipal');
            $table->text('alasan-ipal')->nullable()->after('nomor-dokumen-pertek-ipal');
            
            $table->enum('pengisian-sikelim', ['Ya', 'Tidak'])->nullable()->after('alasan-ipal');
            $table->text('status-sikelim')->nullable()->after('pengisian-sikelim');
            $table->text('alasan-sikelim')->nullable()->after('status-sikelim');
            
            $table->enum('pengisian-dsmiling', ['Ya', 'Tidak'])->nullable()->after('alasan-sikelim');
            $table->text('status-dsmiling')->nullable()->after('pengisian-dsmiling');
            $table->text('alasan-dsmiling')->nullable()->after('status-dsmiling');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Drop document tracking fields
            $table->dropColumn([
                'dokumen-rintek-tps-b3',
                'nomor-dokumen-rintek-tps-b3', 
                'alasan-tps-b3',
                'dokumen-pertek-ipal',
                'nomor-dokumen-pertek-ipal',
                'alasan-ipal',
                'pengisian-sikelim',
                'status-sikelim',
                'alasan-sikelim',
                'pengisian-dsmiling',
                'status-dsmiling',
                'alasan-dsmiling'
            ]);
        });
    }
};

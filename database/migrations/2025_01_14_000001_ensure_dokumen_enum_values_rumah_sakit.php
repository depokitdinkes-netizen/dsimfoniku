<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL for more reliable column type changes
        
        // First, update any integer values to proper string values
        DB::statement("UPDATE rumah_sakit SET `dokumen-rintek-tps-b3` = 'Ya' WHERE `dokumen-rintek-tps-b3` = '1'");
        DB::statement("UPDATE rumah_sakit SET `dokumen-rintek-tps-b3` = 'Tidak' WHERE `dokumen-rintek-tps-b3` = '0'");
        DB::statement("UPDATE rumah_sakit SET `dokumen-pertek-ipal` = 'Ya' WHERE `dokumen-pertek-ipal` = '1'");
        DB::statement("UPDATE rumah_sakit SET `dokumen-pertek-ipal` = 'Tidak' WHERE `dokumen-pertek-ipal` = '0'");
        
        // Set any other invalid values to NULL
        DB::statement("UPDATE rumah_sakit SET `dokumen-rintek-tps-b3` = NULL WHERE `dokumen-rintek-tps-b3` NOT IN ('Ya', 'Tidak') AND `dokumen-rintek-tps-b3` IS NOT NULL");
        DB::statement("UPDATE rumah_sakit SET `dokumen-pertek-ipal` = NULL WHERE `dokumen-pertek-ipal` NOT IN ('Ya', 'Tidak') AND `dokumen-pertek-ipal` IS NOT NULL");
        
        // Now modify the column type to ENUM - using raw SQL to be more explicit
        DB::statement("ALTER TABLE rumah_sakit MODIFY COLUMN `dokumen-rintek-tps-b3` ENUM('Ya', 'Tidak') NULL");
        DB::statement("ALTER TABLE rumah_sakit MODIFY COLUMN `dokumen-pertek-ipal` ENUM('Ya', 'Tidak') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse as we're just cleaning up data
    }
};
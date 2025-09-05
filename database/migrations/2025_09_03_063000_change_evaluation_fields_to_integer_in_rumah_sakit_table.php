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
        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Change all evaluation fields from ENUM to INTEGER to support raw score system
            
            // Section I - Kesehatan Air
            $table->integer('1001')->default(0)->change();
            $table->integer('1002')->default(0)->change();
            $table->integer('1003')->default(0)->change();
            $table->integer('1004')->default(0)->change();
            
            // Section II - Kesehatan Udara
            $table->integer('2001a')->default(0)->change();
            $table->integer('2001b')->default(0)->change();
            $table->integer('2002')->default(0)->change();
            $table->integer('2003a')->default(0)->change();
            $table->integer('2003b')->default(0)->change();
            $table->integer('2003c')->default(0)->change();
            $table->integer('2003d')->default(0)->change();
            $table->integer('2003e')->default(0)->change();
            $table->integer('2003f')->default(0)->change();
            $table->integer('2003g')->default(0)->change();
            $table->integer('2003h')->default(0)->change();
            $table->integer('2003i')->default(0)->change();
            $table->integer('2003j')->default(0)->change();
            $table->integer('2003k')->default(0)->change();
            $table->integer('2004a')->default(0)->change();
            $table->integer('2004b')->default(0)->change();
            $table->integer('2004c')->default(0)->change();
            $table->integer('2004d')->default(0)->change();
            $table->integer('2004e')->default(0)->change();
            $table->integer('2004f')->default(0)->change();
            $table->integer('2004g')->default(0)->change();
            $table->integer('2004h')->default(0)->change();
            $table->integer('2004i')->default(0)->change();
            $table->integer('2004j')->default(0)->change();
            $table->integer('2004k')->default(0)->change();
            $table->integer('2004l')->default(0)->change();
            $table->integer('2004m')->default(0)->change();
            $table->integer('2004n')->default(0)->change();
            $table->integer('2004o')->default(0)->change();
            $table->integer('2004p')->default(0)->change();
            $table->integer('2005a')->default(0)->change();
            $table->integer('2005b')->default(0)->change();
            $table->integer('2005c')->default(0)->change();
            $table->integer('2005d')->default(0)->change();
            $table->integer('2005e')->default(0)->change();
            $table->integer('2005f')->default(0)->change();
            $table->integer('2005g')->default(0)->change();
            $table->integer('2005h')->default(0)->change();
            $table->integer('2005i')->default(0)->change();
            
            // Section III - Kesehatan Pangan
            $table->integer('3001')->default(0)->change();
            $table->integer('3002')->default(0)->change();
            
            // Section IV - Kesehatan Sarana dan Bangunan
            $table->integer('4001')->default(0)->change();
            $table->integer('4002')->default(0)->change();
            $table->integer('4003a')->default(0)->change();
            $table->integer('4003b')->default(0)->change();
            $table->integer('4003c')->default(0)->change();
            $table->integer('4003d')->default(0)->change();
            $table->integer('4004a')->default(0)->change();
            $table->integer('4004c')->default(0)->change();
            $table->integer('4004d')->default(0)->change();
            $table->integer('4004e')->default(0)->change();
            $table->integer('4004f')->default(0)->change();
            $table->integer('4005')->default(0)->change();
            $table->integer('4006a')->default(0)->change();
            $table->integer('4006b')->default(0)->change();
            $table->integer('4006c')->default(0)->change();
            $table->integer('4006d')->default(0)->change();
            $table->integer('4006e')->default(0)->change();
            
            // Section V - Pengendalian Vektor
            $table->integer('5001a')->default(0)->change();
            $table->integer('5001b')->default(0)->change();
            $table->integer('5001c')->default(0)->change();
            $table->integer('5001d')->default(0)->change();
            $table->integer('5001e')->default(0)->change();
            $table->integer('5001f')->default(0)->change();
            $table->integer('5001g')->default(0)->change();
            $table->integer('5001h')->default(0)->change();
            $table->integer('5001i')->default(0)->change();
            $table->integer('5001j')->default(0)->change();
            $table->integer('5002')->default(0)->change();
            
            // Section VI - Pengamanan Limbah
            $table->integer('6001a')->default(0)->change();
            $table->integer('6001b')->default(0)->change();
            $table->integer('6001c')->default(0)->change();
            $table->integer('6002a')->default(0)->change();
            $table->integer('6002b')->default(0)->change();
            $table->integer('6002c')->default(0)->change();
            $table->integer('6002d')->default(0)->change();
            $table->integer('6003a')->default(0)->change();
            $table->integer('6003b')->default(0)->change();
            $table->integer('6004a')->default(0)->change();
            $table->integer('6004b')->default(0)->change();
            $table->integer('6004c')->default(0)->change();
            $table->integer('6004d')->default(0)->change();
            $table->integer('6004e')->default(0)->change();
            
            // Section VII - Pengamanan Radiasi
            $table->integer('7001')->default(0)->change();
            $table->integer('7002')->default(0)->change();
            $table->integer('7003')->default(0)->change();
            
            // Section VIII - Higiene & Sanitasi Karyawan
            $table->integer('8001a')->default(0)->change();
            $table->integer('8001b')->default(0)->change();
            $table->integer('8001c')->default(0)->change();
            $table->integer('8001d')->default(0)->change();
            $table->integer('8001e')->default(0)->change();
            $table->integer('8002a')->default(0)->change();
            $table->integer('8002b')->default(0)->change();
            
            // Section IX - Manajemen Kesehatan Lingkungan
            $table->integer('9001a')->default(0)->change();
            $table->integer('9001b')->default(0)->change();
            $table->integer('9001c')->default(0)->change();
            $table->integer('9001d')->default(0)->change();
            $table->integer('9001e')->default(0)->change();
            $table->integer('9001f')->default(0)->change();
            $table->integer('9002')->default(0)->change();
            $table->integer('9003')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be easily reversed due to data type changes
        // Would require recreating the table with original ENUM definitions
        // For now, we'll leave as integers as they are more flexible
    }
};

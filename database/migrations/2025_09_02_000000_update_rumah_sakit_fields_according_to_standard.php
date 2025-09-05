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
            // Cek dan hapus field yang ada terlebih dahulu
            if (Schema::hasColumn('rumah_sakit', '1002a')) {
                $table->dropColumn('1002a');
            }
            if (Schema::hasColumn('rumah_sakit', '1002b')) {
                $table->dropColumn('1002b');
            }
            if (Schema::hasColumn('rumah_sakit', '1002c')) {
                $table->dropColumn('1002c');
            }
            if (Schema::hasColumn('rumah_sakit', '7a')) {
                $table->dropColumn('7a');
            }
            if (Schema::hasColumn('rumah_sakit', '7b')) {
                $table->dropColumn('7b');
            }
            if (Schema::hasColumn('rumah_sakit', '7c')) {
                $table->dropColumn('7c');
            }
            if (Schema::hasColumn('rumah_sakit', '4004b')) {
                $table->dropColumn('4004b');
            }
            if (Schema::hasColumn('rumah_sakit', 'kelas')) {
                $table->dropColumn('kelas');
            }
        });

        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Tambah field baru hanya jika belum ada
            if (!Schema::hasColumn('rumah_sakit', 'keterangan_sumber_air')) {
                $table->text('keterangan_sumber_air')->nullable()->after('1001');
            }
            if (!Schema::hasColumn('rumah_sakit', '1002')) {
                $table->enum('1002', [4 * 100, 4 * 25, 4 * 0])->after('keterangan_sumber_air');
            }
            if (!Schema::hasColumn('rumah_sakit', 'keterangan_tangki_air')) {
                $table->text('keterangan_tangki_air')->nullable()->after('1002');
            }
            
            if (!Schema::hasColumn('rumah_sakit', 'keterangan_pihak_ketiga_jasa_boga')) {
                $table->text('keterangan_pihak_ketiga_jasa_boga')->nullable()->after('3001');
            }
            if (!Schema::hasColumn('rumah_sakit', 'jumlah_penjamah_pangan')) {
                $table->integer('jumlah_penjamah_pangan')->nullable()->after('keterangan_pihak_ketiga_jasa_boga');
            }
            if (!Schema::hasColumn('rumah_sakit', 'jumlah_penjamah_bersertifikat')) {
                $table->integer('jumlah_penjamah_bersertifikat')->nullable()->after('jumlah_penjamah_pangan');
            }
            
            if (!Schema::hasColumn('rumah_sakit', 'keterangan_pihak_ketiga_pest_control')) {
                $table->text('keterangan_pihak_ketiga_pest_control')->nullable()->after('5001j');
            }
            if (!Schema::hasColumn('rumah_sakit', 'nomor_perizinan_pest_control')) {
                $table->text('nomor_perizinan_pest_control')->nullable()->after('keterangan_pihak_ketiga_pest_control');
            }
            
            if (!Schema::hasColumn('rumah_sakit', 'keterangan_pihak_ketiga_b3')) {
                $table->text('keterangan_pihak_ketiga_b3')->nullable()->after('6002d');
            }
            if (!Schema::hasColumn('rumah_sakit', 'nomor_perizinan_tps_b3')) {
                $table->text('nomor_perizinan_tps_b3')->nullable()->after('keterangan_pihak_ketiga_b3');
            }
            if (!Schema::hasColumn('rumah_sakit', 'nomor_perizinan_ipal')) {
                $table->text('nomor_perizinan_ipal')->nullable()->after('6003b');
            }
            
            if (!Schema::hasColumn('rumah_sakit', '7001')) {
                $table->enum('7001', [0, 10 * 40])->after('6004e'); // 40% dari bobot 10
            }
            if (!Schema::hasColumn('rumah_sakit', '7002')) {
                $table->enum('7002', [0, 10 * 30])->after('7001'); // 30% dari bobot 10
            }
            if (!Schema::hasColumn('rumah_sakit', '7003')) {
                $table->enum('7003', [0, 10 * 30])->after('7002'); // 30% dari bobot 10
            }
            if (!Schema::hasColumn('rumah_sakit', 'memiliki_alat_rontgen_portable')) {
                $table->boolean('memiliki_alat_rontgen_portable')->nullable()->after('7003');
            }
            if (!Schema::hasColumn('rumah_sakit', 'memiliki_shielding_radiasi')) {
                $table->boolean('memiliki_shielding_radiasi')->nullable()->after('memiliki_alat_rontgen_portable');
            }
            
            if (!Schema::hasColumn('rumah_sakit', 'kelas')) {
                $table->enum('kelas', ['A', 'B', 'C', 'D'])->after('kelurahan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Hapus field baru yang ditambahkan (hanya jika ada)
            $fieldsToRemove = [
                'keterangan_sumber_air',
                'keterangan_tangki_air',
                'keterangan_pihak_ketiga_pest_control',
                'nomor_perizinan_pest_control',
                'keterangan_pihak_ketiga_b3',
                'nomor_perizinan_tps_b3',
                'nomor_perizinan_ipal',
                'keterangan_pihak_ketiga_jasa_boga',
                'jumlah_penjamah_pangan',
                'jumlah_penjamah_bersertifikat',
                'memiliki_alat_rontgen_portable',
                'memiliki_shielding_radiasi',
                '1002',
                '7001',
                '7002',
                '7003'
            ];
            
            foreach ($fieldsToRemove as $field) {
                if (Schema::hasColumn('rumah_sakit', $field)) {
                    $table->dropColumn($field);
                }
            }
        });
        
        Schema::table('rumah_sakit', function (Blueprint $table) {
            // Kembalikan field yang dihapus (hanya jika belum ada)
            if (!Schema::hasColumn('rumah_sakit', '1002a')) {
                $table->enum('1002a', [0, 400])->after('1001');
            }
            if (!Schema::hasColumn('rumah_sakit', '1002b')) {
                $table->enum('1002b', [0, 400])->after('1002a');
            }
            if (!Schema::hasColumn('rumah_sakit', '1002c')) {
                $table->enum('1002c', [0, 100])->after('1002b');
            }
            if (!Schema::hasColumn('rumah_sakit', '4004b')) {
                $table->enum('4004b', [0, 40])->after('4004a');
            }
            if (!Schema::hasColumn('rumah_sakit', '7a')) {
                $table->enum('7a', [0, 400])->after('6004e');
            }
            if (!Schema::hasColumn('rumah_sakit', '7b')) {
                $table->enum('7b', [0, 300])->after('7a');
            }
            if (!Schema::hasColumn('rumah_sakit', '7c')) {
                $table->enum('7c', [0, 300])->after('7b');
            }
            if (!Schema::hasColumn('rumah_sakit', 'kelas')) {
                $table->enum('kelas', ['A', 'B', 'C'])->after('kelurahan');
            }
        });
    }
};

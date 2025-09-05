<?php

namespace App\Models\FormIKL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RumahSakit extends Model {
    use HasFactory, SoftDeletes;

    protected $table = "rumah_sakit";
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal-penilaian' => 'date',
    ];

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    protected $fillable = [
            // Informasi Umum
            'subjek', 'alamat', 'kecamatan', 'kelurahan', 'kelas', 'jumlah-tempat-tidur',
            'pengelola', 'kontak', 'nama-pemeriksa', 'instansi-pemeriksa', 'tanggal-penilaian',
            'status-operasi', 'koordinat', 'user_id',
            
            // Form Penilaian - Kesehatan Air (I)
            '1001', '1002', '1003', '1004',
            '1002_selected_id', '9003_selected_id', // Store selected option IDs for fields with duplicate values
            'keterangan_sumber_air', 'keterangan_tangki_air',
            
            // Form Penilaian - Kesehatan Udara (II)
            '2001a', '2001b', '2002',
            '2003a', '2003b', '2003c', '2003d', '2003e', '2003f', '2003g', '2003h', '2003i', '2003j', '2003k',
            '2004a', '2004b', '2004c', '2004d', '2004e', '2004f', '2004g', '2004h', '2004i', '2004j', '2004k', '2004l', '2004m', '2004n', '2004o', '2004p',
            '2005a', '2005b', '2005c', '2005d', '2005e', '2005f', '2005g', '2005h', '2005i',
            
            // Form Penilaian - Kesehatan Pangan (III)
            '3001', '3002',
            'keterangan_pihak_ketiga_jasa_boga', 'jumlah_penjamah_pangan', 'jumlah_penjamah_bersertifikat',
            
            // Form Penilaian - Kesehatan Sarana dan Bangunan (IV)
            '4001', '4002',
            '4003a', '4003b', '4003c', '4003d',
            '4004a', '4004b', '4004c', '4004d', '4004e', '4004f',
            '4005',
            '4006a', '4006b', '4006c', '4006d', '4006e',
            
            // Form Penilaian - Pengendalian Vektor (V)
            '5001a', '5001b', '5001c', '5001d', '5001e', '5001f', '5001g', '5001h', '5001i', '5001j',
            '5002',
            'keterangan_pihak_ketiga_pest_control', 'nomor_perizinan_pest_control',
            
            // Form Penilaian - Pengamanan Limbah (VI)
            '6001a', '6001b', '6001c',
            '6002a', '6002b', '6002c', '6002d',
            '6003a', '6003b',
            '6004a', '6004b', '6004c', '6004d', '6004e',
            'keterangan_pihak_ketiga_b3', 'nomor_perizinan_tps_b3', 'nomor_perizinan_ipal',
            
            // Form Penilaian - Pengamanan Radiasi (VII)
            '7001', '7002', '7003', '7004', '7005',
            'memiliki_alat_rontgen_portable', 'memiliki_shielding_radiasi',
            
            // Form Penilaian - Penyelenggaraan Linen (VIII)
            '8001a', '8001b', '8001c', '8001d', '8001e',
            '8002a', '8002b',
            
            // Form Penilaian - Manajemen Kesehatan Lingkungan (IX)
            '9001a', '9001b', '9001c', '9001d', '9001e', '9001f',
            '9002', '9003',
            
            // Additional fields
            'skor', 'catatan-lain', 'rencana-tindak-lanjut',
            'pelaporan-elektronik', 'pengamanan-radiasi', 'penyehatan-air-hemodiolisa',
            'dokumen-rintek-tps-b3', 'nomor-dokumen-rintek-tps-b3',
            'dokumen-pertek-ipal', 'nomor-dokumen-pertek-ipal',
            'pengisian-sikelim', 'alasan-sikelim',
            'pengisian-dsmiling', 'alasan-dsmiling',
        ];
}

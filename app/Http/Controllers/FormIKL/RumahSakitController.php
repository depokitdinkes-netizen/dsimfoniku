<?php

namespace App\Http\Controllers\FormIKL;

use App\Http\Controllers\Controller;
use App\Models\FormIKL\RumahSakit;
use App\Utils\Export;
use App\Utils\Form;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class RumahSakitController extends Controller
{

    protected function informasiUmum()
    {
        return [
            Form::input('text', 'Nama Rumah Sakit', 'subjek'),
            Form::input('text', 'Alamat', 'alamat'),
            Form::input('text', 'Kecamatan', 'kecamatan'),
            Form::input('text', 'Kelurahan', 'kelurahan'),
            [
                'type' => 'select',
                'label' => 'Kelas Rumah Sakit',
                'name' => 'kelas',
                'option' => [
                    ['label' => 'Kelas A', 'value' => 'A'],
                    ['label' => 'Kelas B', 'value' => 'B'],
                    ['label' => 'Kelas C', 'value' => 'C'],
                    ['label' => 'Kelas D', 'value' => 'D']
                ],
            ],
            Form::input('number', 'Jumlah Tempat Tidur', 'jumlah-tempat-tidur'),
            Form::input('text', 'Nama Penanggung Jawab Kesehatan Lingkungan Rumah Sakit', 'pengelola'),
            Form::input('number', 'Kontak Penanggung Jawab Kesehatan Lingkungan Rumah Sakit', 'kontak'),
            Form::input('text', 'Nama Pemeriksa', 'nama-pemeriksa'),
            Form::input('select', 'Instansi Pemeriksa', 'instansi-pemeriksa'),
            Form::input('date', 'Tanggal Penilaian', 'tanggal-penilaian'),
            Form::selects('status-operasi', 1, 'Status Operasi', [
                Form::option(1, 'Aktif Operasi'),
                Form::option(0, 'Tidak Aktif Operasi')
            ]),
            Form::input('text', 'Titik GPS', 'koordinat'),
            
            // Pertanyaan tambahan untuk dokumen dan sistem
            Form::selects('dokumen-rintek-tps-b3', 1, 'Apakah Memiliki Dokumen Rintek TPS B3?', [
                Form::option('Tidak', 'Tidak'),
                Form::option('Ya', 'Ya')
            ]),
            Form::input('text', 'No Dokumen Rintek TPS B3 (Jika Ya)', 'nomor-dokumen-rintek-tps-b3'),
            Form::selects('dokumen-pertek-ipal', 1, 'Apakah Memiliki Dokumen Pertek IPAL?', [
                Form::option('Tidak', 'Tidak'),
                Form::option('Ya', 'Ya')
            ]),
            Form::input('text', 'No Dokumen Pertek IPAL (Jika Ya)', 'nomor-dokumen-pertek-ipal'),
            Form::selects('pengisian-sikelim', 1, 'Apakah Melakukan Pengisian SIKELIM Setiap Bulan?', [
                Form::option('Tidak', 'Tidak'),
                Form::option('Ya', 'Ya')
            ]),
            Form::input('text', 'Alasan Tidak Mengisi SIKELIM (Jika Tidak)', 'alasan-sikelim'),
            Form::selects('pengisian-dsmiling', 1, 'Apakah Melakukan Pengisian DSMILING Setiap Bulan?', [
                Form::option('Tidak', 'Tidak'),
                Form::option('Ya', 'Ya')
            ]),
            Form::input('text', 'Alasan Tidak Mengisi DSMILING (Jika Tidak)', 'alasan-dsmiling')
        ];
    }

    protected function formPenilaian()
    {
        return [
            Form::h(2, 'I. KESEHATAN AIR RUMAH SAKIT (Bobot: 14)'),
            Form::selects('1001', 4, 'Kuantitas Air Minum (Bobot: 4)', [
                Form::option(100, 'Memenuhi 5 L/TT/hari'),
                Form::option(50, '< 5 L/TT/hari'),
                Form::option(0, 'Tidak memenuhi')]),
            Form::selectc('1002a', 4, 100, 'RS kelas A dan B di ruang rawat inap 400 - 450 liter/TT/hari atau RS kelas C dan D di ruang rawat inap 200 - 300 liter/TT/hari (Bobot: 4)'),
            Form::selectc('1002b', 4, 100, 'Di unit rawat jalan semua kelas rumah sakit 5 L/orang/hari (Bobot: 4)'),
            Form::selectc('1002c', 4, 25, 'Tidak memenuhi persyaratan kuantitas air keperluan higiene dan sanitasi (Bobot: 4)'),
            Form::selects('1003', 3, 'Kualitas Air Minum (Bobot: 3)', [
                Form::option(100, 'Memenuhi syarat (fisik, mikrobiologi, kimia, radioaktivitas)'),
                Form::option(50, 'Sebagian memenuhi'),
                Form::option(0, 'Tidak memenuhi')]),
            Form::selects('1004', 3, 'Kualitas Air untuk Keperluan Higiene dan Sanitasi (Bobot: 3)', [
                Form::option(100, 'Memenuhi syarat (fisik, mikrobiologi, kimia, radioaktivitas)'),
                Form::option(50, 'Sebagian memenuhi'),
                Form::option(0, 'Tidak memenuhi')]),
            Form::h(2, 'II. KESEHATAN UDARA RUMAH SAKIT (Bobot: 10)'),
            Form::h(3, 'Standar Baku Mutu Mikrobiologi Udara (Bobot: 2)'),
            Form::selectc('2001a', 2, 50, 'Ruang operasi kosong: 35 CFU/m³'),
            Form::selectc('2001b', 2, 50, 'Ruang operasi ada aktivitas: 180 CFU/m³'),
            Form::selects('2002', 2, 'Kelembaban Udara (Bobot: 2)', [
                Form::option(100, 'Semua ruangan memenuhi (40–60%)'),
                Form::option(50, 'Sebagian ruangan')]),
            Form::h(3, 'Pencahayaan (Bobot: 2)'),
            Form::selectc('2003a', 2, 10, 'Ruang pasien (tidak tidur: 100 lux; tidur: 50 lux)'),
            Form::selectc('2003b', 2, 10, 'Rawat jalan (100 lux)'),
            Form::selectc('2003c', 2, 10, 'IGD (100 lux, meja tindakan + lampu sorot)'),
            Form::selectc('2003d', 2, 10, 'Operasi umum (300–500 lux)'),
            Form::selectc('2003e', 2, 10, 'Meja operasi (10,000–20,000 lux)'),
            Form::selectc('2003f', 2, 10, 'Anestesi pemulihan (300–500 lux)'),
            Form::selectc('2003g', 2, 10, 'Endoskopi, lab (75–100 lux)'),
            Form::selectc('2003h', 2, 10, 'Sinar X (minimal 60 lux)'),
            Form::selectc('2003i', 2, 5, 'Koridor (minimal 100 lux)'),
            Form::selectc('2003j', 2, 5, 'Tangga (minimal 100 lux)'),
            Form::selectc('2003k', 2, 10, 'Administrasi/kantor (minimal100 lux)'),
            Form::h(3, 'Kebisingan (Bobot: 2)'),
            Form::selectc('2004a', 2, 15, 'Ruang pasien (tidak tidur: 65 dBA; tidur: 55 dBA)'),
            Form::selectc('2004b', 2, 10, 'Operasi umum (65 dBA)'),
            Form::selectc('2004c', 2, 5, 'Ruang umum (65 dBA)'),
            Form::selectc('2004d', 2, 5, 'Anestesi pemulihan (65 dBA)'),
            Form::selectc('2004e', 2, 5, 'Endoskopi, lab (65 dBA)'),
            Form::selectc('2004f', 2, 5, 'Sinar X (65 dBA)'),
            Form::selectc('2004g', 2, 5, 'Koridor (65 dBA)'),
            Form::selectc('2004h', 2, 5, 'Tangga (65 dBA)'),
            Form::selectc('2004i', 2, 5, 'Kantor/lobby (65 dBA)'),
            Form::selectc('2004j', 2, 5, 'Ruang alat/gudang (65 dBA)'),
            Form::selectc('2004k', 2, 5, 'Farmasi (65 dBA)'),
            Form::selectc('2004l', 2, 5, 'Ruang cuci (80 dBA)'),
            Form::selectc('2004m', 2, 10, 'Ruang isolasi (55 dBA)'),
            Form::selectc('2004n', 2, 5, 'Ruang poligigi (65 dBA)'),
            Form::selectc('2004o', 2, 5, 'Ruang ICU (65 dBA)'),
            Form::selectc('2004p', 2, 5, 'Ambulans (85 dBA)'),
            Form::h(3, 'Kualitas Udara (Bobot: 2)'),
            Form::selectc('2005a', 2, 10, 'Karbon monoksida maks. 10,000 µg/m³'),
            Form::selectc('2005b', 2, 10, 'Karbondioksida maks. 1 ppm'),
            Form::selectc('2005c', 2, 10, 'Timbal maks. 0.5 µg/m³'),
            Form::selectc('2005d', 2, 10, 'Nitrogen dioksida maks. 200 µg/m³'),
            Form::selectc('2005e', 2, 10, 'Sulfur dioksida maks. 125 µg/m³'),
            Form::selectc('2005f', 2, 10, 'Formaldehida maks. 100 µg/m³'),
            Form::selectc('2005g', 2, 10, 'TVOC maks. 3 ppm'),
            Form::selectc('2005h', 2, 15, 'Tidak berbau (bebas H₂S, amonia)'),
            Form::selectc('2005i', 2, 15, 'Debu PM10 maks. 150 µg/m³; PM2.5 maks. 25 µg/m³'),
            Form::h(2, 'III. KESEHATAN PANGAN SIAP SAJI RUMAH SAKIT (Bobot: 10)'),
            Form::selects('3001', 5, 'Standar Mutu Pangan Siap Saji (Bobot: 5)', [
                Form::option(100, 'Sertifikat jasa boga golongan B'),
                Form::option(0, 'Tidak memiliki')]),
            Form::input('text', 'Keterangan: Nama pihak ketiga?', 'keterangan_pihak_ketiga_pangan'),
            Form::input('text', 'Keterangan: Jumlah total penjamah pangan?', 'keterangan_total_penjamah'),
            Form::input('text', 'Keterangan: Jumlah penjamah pangan bersertifikat?', 'keterangan_penjamah_bersertifikat'),
            Form::selects('3002', 5, 'Hasil IKL Jasa Boga B (Bobot: 5)', [
                Form::option(100, 'Ya'),
                Form::option(0, 'Tidak')]),
            Form::h(2, 'IV. KESEHATAN SARANA DAN BANGUNAN (Bobot: 10)'),
            Form::selects('4001', 2, 'Toilet Pengunjung (Bobot: 2)', [
                Form::option(100, 'Wanita 1:20, pria 1:30'),
                Form::option(50, 'Tidak sesuai')]),
            Form::selects('4002', 2, 'Toilet Disabilitas (Bobot: 2)', [
                Form::option(100, 'Tersedia di rawat jalan, penunjang medik, IGD'),
                Form::option(0, 'Tidak')]),
            Form::h(3, 'Lantai Rumah Sakit (Bobot: 2)'),
            Form::selectc('4003a', 2, 25, 'Permukaan rata, tidak licin, warna terang, mudah dibersihkan'),
            Form::selectc('4003b', 2, 25, 'Kemiringan cukup ke saluran pembuangan'),
            Form::selectc('4003c', 2, 25, 'Pertemuan lantai-dinding konus/lengkung'),
            Form::selectc('4003d', 2, 25, 'Dinding kuat, rata, warna terang, cat tidak luntur'),
            Form::h(3, 'Pintu Rumah Sakit (Bobot: 2)'),
            Form::selectc('4004a', 2, 20, 'Pintu utama minimal 120 cm, lainnya minimal 90 cm'),
            Form::selectc('4004b', 2, 20, 'Tidak ada perbedaan ketinggian lantai di pintu masuk'),
            Form::selectc('4004c', 2, 15, 'Pintu toilet aksesibel terbuka keluar'),
            Form::selectc('4004d', 2, 15, 'Pintu akses brankar dilapisi bahan anti-benturan'),
            Form::selectc('4004e', 2, 15, 'Ruang perawatan ada jendela pertukaran udara'),
            Form::selectc('4004f', 2, 15, 'Jendela aman dari pelarian pasien'),
            Form::selects('4005', 1, 'Atap Rumah Sakit (Bobot: 1)', [
                Form::option(100, 'Kuat, tidak bocor, tahan lama, tidak jadi sarang'),
                Form::option(50, 'Memenuhi sebagian')]),
            Form::h(3, 'Langit-langit Rumah Sakit (Bobot: 2)'),
            Form::selectc('4006a', 2, 40, 'Kuat, warna terang, mudah dibersihkan, tidak berjamur'),
            Form::selectc('4006b', 2, 40, 'Tinggi minimal: ruangan 2.8 m, selasar 2.4 m'),
            Form::selectc('4006c', 2, 40, 'Ruang operasi minimal 3 m'),
            Form::selectc('4006d', 2, 40, 'Tahan api 2 jam di ruang operasi/ICU'),
            Form::selectc('4006e', 2, 40, 'Lampu dibenamkan di plafon'),
            Form::h(2, 'V. PENGENDALIAN VEKTOR DAN BINATANG PEMBAWA PENYAKIT (Bobot: 10)'),
            Form::h(3, 'Angka Kepadatan Vektor (Bobot: 5)'),
            Form::selectc('5001a', 5, 10, 'Anopheles sp. MBR <0.025'),
            Form::input('text', 'Keterangan: Nama pihak ketiga pest control?', 'keterangan_pihak_ketiga_pest'),
            Form::selectc('5001b', 5, 10, 'Larva Anopheles sp. indeks habitat <1'),
            Form::selectc('5001c', 5, 10, 'Aedes aegypti/albopictus resting rate <0.025'),
            Form::selectc('5001d', 5, 10, 'Larva Aedes aegypti/albopictus ABJ minimal 95'),
            Form::input('text', 'Keterangan: Nomor dan tahun perijinan pest control?', 'keterangan_perijinan_pest'),
            Form::selectc('5001e', 5, 10, 'Culex sp. MHD <1'),
            Form::selectc('5001f', 5, 10, 'Larva Culex sp. indeks habitat <5'),
            Form::selectc('5001g', 5, 10, 'Mansonia sp. MHD <5'),
            Form::selectc('5001h', 5, 10, 'Pinjal indeks khusus <1'),
            Form::selectc('5001i', 5, 10, 'Lalat indeks populasi <2'),
            Form::selectc('5001j', 5, 10, 'Kecoa indeks populasi <2'),
            Form::selects('5002', 5, 'Angka Kepadatan Binatang Pembawa Penyakit (Bobot: 5)', [
                Form::option(100, 'Tikus success trap <1'),
                Form::option(0, 'Tikus success trap >1')]),
            Form::h(2, 'VI. PENGAMANAN LIMBAH (Bobot: 16)'),
            Form::h(3, 'Limbah Padat Domestik (Bobot: 5)'),
            Form::selectc('6001a', 5, 40, 'Penanganan limbah dengan 3R'),
            Form::selectc('6001b', 5, 30, 'Memiliki TPS limbah domestik'),
            Form::selectc('6001c', 5, 30, 'Pengangkutan TPS maks. 2x24 jam'),
            Form::h(3, 'Limbah Padat B3 (Bobot: 5)'),
            Form::selectc('6002a', 5, 20, 'Pemilahan medis & non-medis'),
            Form::input('text', 'Keterangan: Nomor dan tahun perijinan pemilahan?', 'keterangan_perijinan_pemilahan'),
            Form::selectc('6002b', 5, 20, 'Penyimpanan sesuai ketentuan'),
            Form::selectc('6002c', 5, 20, 'TPS B3 berizin'),
            Form::input('text', 'Keterangan: Nomor izin TPS LB3?', 'keterangan_izin_tps_lb3'),
            Form::selectc('6002d', 5, 40, 'Pengolahan limbah B3 berizin (internal/eksternal)'),
            Form::input('text', 'Keterangan: Nama pihak ketiga dan nomor perijinan?', 'keterangan_pihak_ketiga_b3'),
            Form::h(3, 'Limbah Cair (Bobot: 4)'),
            Form::selectc('6003a', 4, 50, 'Memiliki IPAL berizin'),
            Form::input('text', 'Keterangan: Nomor dan tahun perijinan IPAL?', 'keterangan_perijinan_ipal'),
            Form::selectc('6003b', 4, 50, 'Hasil olahan limbah cair sesuai baku mutu'),
            Form::h(3, 'Limbah Gas (Bobot: 2)'),
            Form::selectc('6004a', 2, 20, 'Memenuhi penaatan dalam frekuensi  pengambilan contoh pemeriksaan emisi gas buang dan udara ambien luar'),
            Form::selectc('6004b', 2, 20, 'Kualitas emisi gas buang dan partikulat dari cerobong memenuhi standar kualitas udara sesuai dengan ketentuan peraturan perundangundangan tentang standar kualitas gas emisi sumber tidak bergerak'),
            Form::selectc('6004c', 2, 20, 'Memenuhi penaatan pelaporan hasil uji atau pengukuran laboratorium limbah gas kepada instansi pemerintah sesuai ketentuan, minimal setiap 1 kali setahun'),
            Form::selectc('6004d', 2, 20, 'Setiap sumber emisi gas berbentuk cerobong tinggi seperti generator set, boiler dilengkapi dengan fasilitas penunjang uji emisi.'),
            Form::selectc('6004e', 2, 20, 'cerobong gas buang di rumah sakit dilengkapi dengan alat kelengkapan cerobong.'),
            Form::h(2, 'VII. PENGAMANAN RADIASI (Bobot: 10)'),
            Form::h(3, 'Pengamanan Radiasi (Bobot: 10)'),
            Form::selectc('7001', 10, 40, 'Izin penggunaan alat dari BAPETEN'),
            Form::selectc('7002', 10, 30, 'Peralatan proteksi radiasi'),
            Form::selectc('7003', 10, 30, 'Pemantauan pekerja radiasi dengan APD'),
            Form::selectc('7004', 10, 20, 'Memiliki alat rontgen portable'),
            Form::selectc('7005', 10, 20, 'Jika memiliki Alat Rotgen Portable, apakah memiliki Shielding radiasi yang berbentuk segitiga/shieling mengelilingi pada saat proses dilakukan'),
            Form::h(2, 'VIII. PENYELENGGARAAN LINEN (Bobot: 10)'),
            Form::h(3, 'Penyelenggaraan Linen Internal (Bobot: 7)'),
            Form::selectc('8001a', 7, 20, 'Air higiene/sanitasi & air panas memadai'),
            Form::selectc('8001b', 7, 20, 'Pemilahan linen infeksius & non-infeksius'),
            Form::selectc('8001c', 7, 20, 'Pencucian terpisah linen infeksius/non-infeksius'),
            Form::selectc('8001d', 7, 20, 'Ruang pemisah linen bersih/kotor'),
            Form::selectc('8001e', 7, 20, 'Perlakuan memenuhi persyaratan'),
            Form::h(3, 'Penyelenggaraan Linen Eksternal (Bobot: 3)'),
            Form::selectc('8002a', 3, 50, 'Ada MoU dengan pihak ketiga'),
            Form::selectc('8002b', 3, 50, 'Pengawasan rutin'),
            Form::h(2, 'IX. MANAJEMEN KESEHATAN LINGKUNGAN RUMAH SAKIT (Bobot: 10)'),
            Form::h(3, 'Manajemen Kesling RS (Bobot: 4)'),
            Form::selectc('9001a', 4, 25, 'Ada unit/instalasi sanitasi'),
            Form::selectc('9001b', 4, 15, 'Dokumen administrasi (SK, SOP)'),
            Form::selectc('9001c', 4, 20, 'Dokumen lingkungan sah pemerintah'),
            Form::selectc('9001d', 4, 20, 'Rencana kerja bidang kesling'),
            Form::selectc('9001e', 4, 10, 'Monitoring & evaluasi'),
            Form::selectc('9001f', 4, 10, 'Laporan rutin'),
            Form::selects('9002', 3, 'Peralatan Kesling (Bobot: 3)', [
                Form::option(100, 'Semua peralatan'),
                Form::option(50, 'Sebagian peralatan'),
                Form::option(0, 'Tidak ada')]),
            Form::selects('9003', 3, 'Tenaga Kesehatan Lingkungan (Bobot: 3)', [
                Form::option(100, 'Penanggung jawab kesehatan lingkungan rumah sakit, baik pemerintah maupun swasta, harus memiliki pendidikan di bidang kesehatan lingkungan, sanitasi, teknik lingkungan, atau teknik penyehatan, dengan kualifikasi minimal Sarjana (S1) atau Diploma IV untuk kelas A dan B, serta minimal Diploma III (D3) untuk kelas C dan D'),
                Form::option(25, 'Tidak sesuai kriteria')]),
            Form::h(2, 'X. INFORMASI TAMBAHAN'),
            Form::input('textarea', 'Pelaporan Elektronik', 'pelaporan_elektronik'),
            Form::input('textarea', 'Pengamanan Radiasi', 'pengamanan_radiasi'),
            Form::input('textarea', 'Penyehatan Air Hemodialisa', 'penyehatan_air_hemodialisa'),
            Form::input('textarea', 'Catatan Lain', 'catatan_lain'),
            Form::input('textarea', 'Rencana Tindak Lanjut', 'rencana_tindak_lanjut'),
        ];
    }

    protected function formPenilaianName()
    {
        return array_column($this->formPenilaian(), 'name');
    }

    protected function formPenilaianScoreFields()
    {
        // Only return fields that have scoring (selectc, selects types)
        $formFields = $this->formPenilaian();
        $scoreFields = [];
        
        foreach ($formFields as $field) {
            if (isset($field['type']) && isset($field['name']) && 
                in_array($field['type'], ['selectc', 'selects'])) {
                $scoreFields[] = $field['name'];
            }
        }
        
        return $scoreFields;
    }

    /**
     * Get default value for specific field based on its form definition
     * Returns the lowest possible score (0) to avoid inflated scores
     */
    protected function getDefaultValueForField($fieldName)
    {
        // Always return 0 for realistic baseline score
        // This ensures that when users don't fill any fields,
        // the score starts from 0 instead of inflated values
        return '0';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        switch ($request->export) {
            case 'pdf':
                $item = RumahSakit::find($request->id);

                if (!$item) {
                    return abort(404);
                }

                Carbon::setLocale('id');

                return Pdf::loadView('pdf', [
                    'form' => 'Rumah Sakit',
                    'tanggal' => Carbon::parse($item['tanggal-penilaian'])->format('d'),
                    'bulan' => Carbon::parse($item['tanggal-penilaian'])->translatedFormat('F'),
                    'tahun' => Carbon::parse($item['tanggal-penilaian'])->format('Y'),
                    'informasi' => [
                        ['Nama Rumah Sakit', $item['subjek']],
                        ['Nama Pengelola/Pemilik/Penanggung Jawab', $item['pengelola']],
                        ['Kontak Pengelola', $item['kontak']],
                        ['Alamat', $item['alamat']],
                        ['Kelurahan', $item['kelurahan']],
                        ['Kecamatan', $item['kecamatan']],
                        ['Skor', Export::score($item['skor'], Export::RUMAH_SAKIT)],

                        ['Kelas', $item['kelas']],
                        ['Jumlah Tempat Tidur', $item['jumlah-tempat-tidur']]],
                    'catatan' => $item['catatan-lain'],
                    'rencana' => $item['rencana-tindak-lanjut'],
                    'pengelola' => $item['pengelola'],
                    'pemeriksa' => $item['nama-pemeriksa']])->download('BAIKL_RUMAH_SAKIT_' . str_pad($item['id'], 5, '0', STR_PAD_LEFT) . '.pdf');
            case 'excel':
                return Excel::download(new class implements FromCollection, WithHeadings
                {
                    public function collection()
                    {
                        return RumahSakit::withTrashed()->get();
                    }

                    public function headings(): array
                    {
                        return [
                            'Id',
                            'Nama Subjek',
                            'Nama Pengelola',
                            'Alamat',
                            'Kelurahan',
                            'Kecamatan',
                            'Kontak',
                            'Status Operasi',
                            'Koordinat',
                            'Nama Pemeriksa',
                            'Instansi Pemeriksa',
                            'Tanggal Penilaian',
                            'Skor',
                            'Pelaporan Elektronik',
                            'Pengamanan Radiasi',
                            'Penyehatan Air Hemodiolisa',
                            'Hasil IKL',
                            'Rencana Tindak Lanjut',
                            'Dibuat',
                            'Diperbarui',
                            'Dihapus',

                            'Kelas',
                            'Jumlah Tempat Tidur',

                            'Kuantitas air minum',
                            'RS kelas A dan B di ruang rawat inap 400 - 450 liter/TT/hari atau RS kelas C dan D di ruang rawat inap 200 - 300 liter/TT/hari',
                            'Di unit rawat jalan semua kelas rumah sakit 5 L/orang/hari',
                            'Tidak memenuhi persyaratan kuantitas air keperluan higiene dan sanitasi',
                            'Kualitas air minum',
                            'Kualitas air untuk keperluan higiene dan sanitasi',
                            'Ruang operasi kosong, 35 CFU/m³',
                            'Ruang operasi ada aktifitas, 180 CFU/m³',
                            'Memenuhi standar baku mutu fisik untuk kelembaban udara',
                            'Ruang pasien saat tidak tidur (250 lux) dan saat tidur (50 lux)',
                            'Rawat Jalan (200 lux)',
                            'Unit Gawat Darurat (300 lux)',
                            'Operasi Umum (300-500 lux)',
                            'Meja Operasi (10.000-20.000 lux)',
                            'Anastesi pemulihan (300-500 lux)',
                            'Endoscopy, lab (75-100 lux)',
                            'Sinar X (minimal 60 lux)',
                            'Koridor (minimal 100 lux)',
                            'Tangga (minimal 100 lux)',
                            'Administrasi/Kantor (minimal 100 lux)',
                            'Ruang pasien saat tidak tidur (45 dBA) dan saat tidur (40 dBA)',
                            'Operasi Umum (45 dBA)',
                            'Ruang Umum (45 dBA)',
                            'Anastesi pemulihan(50 dBA)',
                            'Endoscopy, lab (65 dBA)',
                            'Sinar X (40 dBA)',
                            'Koridor (45 dBA)',
                            'Tangga (65 dBA)',
                            'Kantor/lobby (65 dBA)',
                            'Ruang alat /gudang (65 dBA)',
                            'Farmasi (65 dBA)',
                            'Ruang cuci (80 dBA)',
                            'Ruang isolasi (20 dBA)',
                            'Ruang poligigi (65 dBA)',
                            'Ruang ICU (65 dBA)',
                            'Ambulans (40 dBA)',
                            'Karbon monoksida maks. 10.000μg/m³',
                            'Karbodioksida maks. 1 ppm',
                            'Timbal maks. 0,5 μg/m³',
                            'Nitrogen dioksida maks. 200 μg/m³',
                            'Sulfur dioksida maks. 125 μg/m³',
                            'Formaldehida maks 100 μg/m³',
                            'Total senyawa organik yang mudah menguap (T.VOC) maks. 3',
                            'Tidak berbau (bebas H2S dan amoniak)',
                            'Kadar debu (diameter <10 mikron atau tidak melebihi 150 μg/m³ dan tidak mengandung debu asbes)',
                            'Memenuhi standar baku mutu pangan siap saji',
                            'Hasil IKL memenuhi syarat jasaboga golongan B',
                            'Toilet pengunjung',
                            'Tersedia toilet untuk orang yang keterbatasan fisik (disabilitas) di ruang rawat jalan, penunjang medik dan IGD',
                            'lantai terbuat dari bahan yang kuat, kedap air, permukaan rata, tidak licin, warna terang, dan mudah dibersihkan.',
                            'lantai yang selalu kontak dengan air harus mempunyai kemiringan yang cukup ke arah saluran pembuangan air limbah.',
                            'Pertemuan lantai dengan dinding harus berbentuk Konus atau lengkung agar mudah dibersihkan.',
                            'Permukaan dinding harus kuat rata, berwarna terang dan menggunakan cat yang tidak luntur serta tidak menggunakan cat yang mengandung logam berat.',
                            'Pintu utama dan pintu-pintu yang dilalui brankar/tempat tidur pasien memiliki lebar bukaan minimal 120 cm, dan pintu- pintu yang tidak menjadi akses tempat tidur pasien memiliki lebar bukaan minimal 90 cm.',
                            'Di daerah sekitar pintu masuk tidak boleh ada perbedaan ketinggian lantai.',
                            'Pintu untuk kamar mandi di ruangan perawatan pasien dan pintu toilet untuk aksesibel, harus terbuka ke luar, dan lebar',
                            'Pintu-pintu yang menjadi akses tempat tidur pasien harus dilapisi bahan anti benturan.',
                            'Ruang perawatan pasien harus memiliki bukaan jendela yang dapat terbuka secara maksimal untuk kepentingan pertukaran udara.',
                            'Pada bangunan rumah sakit bertingkat, lebar bukaan jendela harus aman dari kemungkinan pasien dapat melarikan/meloloskan diri.',
                            'Atap rumah sakit',
                            'Langit-langit kuat, berwarna terang, dan mudah dibersihkan, tidak mengandung unsur yang dapat membahayakan pasien, tidak berjamur.',
                            'Tinggi langit-langit di ruangan minimal 2,80 m, dan tinggi di selasar (koridor) minimal 2,40 m.',
                            'Tinggi langit-langit di ruangan operasi minimal 3,00 m.',
                            'Pada ruang operasi dan ruang perawatan intensif, bahan langit- langit harus memiliki tingkat ketahanan api (TKA) minimal 2 jam.',
                            'Pada tempat-tempat yang membutuhkan tingkat kebersihan ruangan tertentu, maka lampu-lampu penerangan ruangan dipasang dibenamkan pada plafon (recessed).',
                            'Nyamuk Anopheles sp. MBR (Man biting rate) <0,025',
                            'Larva Anopheles sp. indeks habitat <1',
                            'Nyamuk Aedes aegypti dan/atau Aedes albopictus Angka Istirahat (Resting rate) <0,025',
                            'Larva Aedes aegypti dan /atau ABJ (Angka Bebas Jentik) minimal 95',
                            'Nyamuk Culex sp. MHD (Man Hour Density) <1',
                            'Larva Culex sp. indeks habitat <5',
                            'Mansonia sp., MHD (Man Hour Density) <5',
                            'Pinjal, Indeks Pinjal Khusus <1',
                            'Lalat, Indeks Populasi Lalat <2',
                            'Kecoa, Indeks Populasi Kecoa <2',
                            'Angka kepadatan untuk binatang pembawa penyakit',
                            'Melakukan penanganan limbah dengan 3R',
                            'Memiliki TPS limbah domestik',
                            'Pengangkutan di TPS dilakukan tidak boleh lebih dari 2x24 jam',
                            'Melakukan pemilahan limbah medis dan non medis',
                            'Memenuhi ketentuan lamanya penyimpanan limbah medis B3',
                            'Memiliki TPS B3 yang berizin',
                            'Memiliki pengolahan limbah B3 sendiri (incenerator atau autoclaf dll) yang berizin dan atau pihak ke tiga yang berizin',
                            'Memiliki IPAL dengan izin',
                            'hasil pengolahan limbah cair memenuhi baku mutu',
                            'Memenuhi penaatan dalam frekuensi pengambilan contoh pemeriksaan emisi gas buang dan udara ambien luar',
                            'Kualitas emisi gas buang dan partikulat dari cerobong memenuhi standar kualitas udara sesuai dengan ketentuan peraturan perundang- undangan tentang standar kualitas gas emisi sumber tidak bergerak',
                            'Memenuhi penaatan pelaporan hasil uji atau pengukuran laboratorium limbah gas kepada instansi pemerintah sesuai ketentuan, minimal setiap 1 kali setahun',
                            'Setiap sumber emisi gas berbentuk cerobong tinggi seperti generator set, boiler dilengkapi dengan fasilitas penunjang uji emisi.',
                            'cerobong gas buang di rumah sakit dilengkapi dengan alat kelengkapan cerobong.',
                            'Rumah sakit mempunyai izin penggunaan alat dari Badan Pengawas Tenaga Nuklir (BAPETEN)',
                            'Mempunyai peralatan proteksi radiasi',
                            'Melakukan pemantauan pekerja radiasi menggunakan alat proteksi diri',
                            'Terdapat keran air keperluan higiene dan sanitasi dengan tekanan cukup dan kualitas air yang memenuhi persyaratan baku mutu, juga tersedia air panas dengan tekanan dan suhu yang memadai.',
                            'Dilakukan pemilahan antara linen infeksius dan non infeksius',
                            'Dilakukan pencucian secara terpisah antara linen infeksius dan noninfeksius.',
                            'Tersedia ruang pemisah antara linen bersih dan linen kotor',
                            'Memenuhi persyaratan perlakuan terhadap linen, yaitu',
                            'Adanya MoU dengan Pihak Ke tiga',
                            'Pengawasan rutin',
                            'Ada unit/instalasi Sanitasi Rumah Sakit',
                            'memiliki dokumen administrasi kesehatan lingkungan rumah sakit yang meliputi panduan/pedoman (seperti SK,SOP)',
                            'memiliki dokumen lingkungan hidup yang telah disahkan oleh instansi Pemerintah atau sesuai dengan ketentuan peraturan perundang-undangan',
                            'Memiliki rencana kerja bidang kesling',
                            'Melaksanakan monitoring dan evaluasi kegiatan kesehatan lingkungan rumah sakit',
                            'Membuat laporan rutin ke direksi/pimpinan rumah sakit dan instansi yang berwenang',
                            'Peralatan kesling',
                            'Tenaga kesehatan lingkungan rumah sakit']; }
                    }, 'REPORT_RUMAH_SAKIT_' . Carbon::now()->format('Ymd') . '.xlsx');
            default:
                abort(404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.inspection.rumah-sakit.create', [
            'page_name' => 'inspection',
            'informasi_umum' => $this->informasiUmum(),
            'form_penilaian' => $this->formPenilaian()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi input dengan custom error messages
            $request->validate([
                'subjek' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'kelas' => 'required|string|max:255',
                'jumlah-tempat-tidur' => 'required|numeric|min:1',
                'pengelola' => 'required|string|max:255',
                'kontak' => 'required|string|max:255',
                'nama-pemeriksa' => 'required|string|max:255',
                'instansi-pemeriksa' => 'required|string|max:255',
                'tanggal-penilaian' => 'required|date',
                'koordinat' => 'required|string|regex:/^-?\d+\.?\d*,\s*-?\d+\.?\d*$/',
                'status-operasi' => 'required|in:0,1',
                'dokumen-rintek-tps-b3' => 'required|in:Ya,Tidak',
                'no-dokumen-rintek-tps-b3' => 'nullable|string|max:255',
                'dokumen-pertek-ipal' => 'required|in:Ya,Tidak',
                'no-dokumen-pertek-ipal' => 'nullable|string|max:255',
                'pengisian-sikelim' => 'required|in:Ya,Tidak',
                'alasan-sikelim' => 'nullable|string|max:500',
                'pengisian-dsmiling' => 'required|in:Ya,Tidak',
                'alasan-dsmiling' => 'nullable|string|max:500',
                
                // Validasi field keterangan baru
                'keterangan_pihak_ketiga_jasa_boga' => 'nullable|string|max:255',
                'jumlah_penjamah_pangan' => 'nullable|integer|min:0',
                'jumlah_penjamah_bersertifikat' => 'nullable|integer|min:0',
                'keterangan_pihak_ketiga_pest_control' => 'nullable|string|max:255',
                'nomor_perizinan_pest_control' => 'nullable|string|max:255',
                'keterangan_pihak_ketiga_b3' => 'nullable|string|max:500',
                'nomor_perizinan_tps_b3' => 'nullable|string|max:255',
                'nomor_perizinan_ipal' => 'nullable|string|max:255',
                'memiliki_alat_rontgen_portable' => 'nullable|in:0,1',
                'memiliki_shielding_radiasi' => 'nullable|in:0,1',
                
                // Validasi field penilaian utama
                '1001' => 'nullable|in:0,25,50,100',
                '1002a' => 'nullable|in:0,400',
                '1002b' => 'nullable|in:0,400',
                '1002c' => 'nullable|in:0,100',
                '1003' => 'nullable|in:0,50,100',
                '1004' => 'nullable|in:0,50,100',
            ]);

            $data = $request->all();
            
            // Handle instansi-lainnya logic
            if (isset($data['instansi-pemeriksa']) && $data['instansi-pemeriksa'] === 'Lainnya' && isset($data['instansi-lainnya'])) {
                $data['instansi-pemeriksa'] = $data['instansi-lainnya'];
                unset($data['instansi-lainnya']);
            }
            
            // Add user ID
            $data['user_id'] = Auth::id();

            // Process penilaian columns with proper defaults based on field type
            foreach ($this->formPenilaianName() as $column) {
                // For selectc fields (1002a, 1002b, 1002c), use exact request value if present
                if (in_array($column, ['1002a', '1002b', '1002c']) && $request->has($column)) {
                    $data[$column] = $request->input($column);
                } else {
                    // Get default value based on field specifications
                    $defaultValue = $this->getDefaultValueForField($column);
                    $data[$column] = $request->input($column, $defaultValue);
                }
                
                // DEBUG: Log field processing to see what's happening
                if (in_array($column, ['1001', '1002a', '1002b', '1002c', '1003', '1004', '2001a'])) {
                    Log::info("Field Processing Debug", [
                        'field' => $column,
                        'request_value' => $request->input($column, 'NOT_SET'),
                        'default_value' => in_array($column, ['1002a', '1002b', '1002c']) ? 'DIRECT_FROM_REQUEST' : $this->getDefaultValueForField($column),
                        'final_value' => $data[$column],
                        'request_has_field' => $request->has($column)
                    ]);
                }
            }
            
            // Handle special fields with specific handling
            // Ensure these fields get their correct values from request (not processed by getDefaultValueForField)
            
            if ($request->has('9003')) {
                $data['9003'] = $request->input('9003');
            } else {
                // Set default values
                $data['9003'] = $this->getDefaultValueForField('9003');
            }
            

            
            if ($request->has('memiliki_alat_rontgen_portable')) {
                $data['memiliki_alat_rontgen_portable'] = $request->input('memiliki_alat_rontgen_portable');
            }
            if ($request->has('memiliki_shielding_radiasi')) {
                $data['memiliki_shielding_radiasi'] = $request->input('memiliki_shielding_radiasi');
            }
            
            // Set default values for dokumen fields (default: tidak)
            $data['dokumen-rintek-tps-b3'] = $request->input('dokumen-rintek-tps-b3', 'Tidak');
            $data['dokumen-pertek-ipal'] = $request->input('dokumen-pertek-ipal', 'Tidak');
            
            // Set default values for pengisian fields (default: ya)
            $data['pengisian-sikelim'] = $request->input('pengisian-sikelim', 'Ya');
            $data['pengisian-dsmiling'] = $request->input('pengisian-dsmiling', 'Ya');
            
            // Calculate raw score and normalize to 10,000 based on max score 11,000
            $totalScoreObtained = array_reduce($this->formPenilaianScoreFields(), function($carry, $column) use ($request) {
                $value = $request->input($column, 0);
                return $carry + (is_numeric($value) ? (int)$value : 0);
            }, 0);
            // Normalize raw score to 10,000 with max score 11,000
            $normalizedScore = round(($totalScoreObtained / 11200) * 10000);
            $data['skor'] = $normalizedScore;

            // Log total score for debugging
            Log::info('Rumah Sakit Store - Total Score Calculated', [
                'raw_score' => $totalScoreObtained,
                'normalized_score' => $normalizedScore,
                'max_raw_score' => 11200,
                'max_normalized_score' => 10000,
                'percentage' => round(($totalScoreObtained / 11200) * 100, 2) . '%',
                'category' => $normalizedScore >= 8600 ? 'Sangat Baik' : ($normalizedScore >= 6500 ? 'Baik' : 'Kurang'),
                'user_id' => Auth::id(),
                'subjek' => $request->input('subjek'),
                'form_data_sample' => array_slice($request->all(), 0, 5) // First 5 fields for context
            ]);

            // Log detailed field scores for debugging
            $fieldScores = [];
            foreach ($this->formPenilaianScoreFields() as $column) {
                $value = $request->input($column, 0);
                $numValue = is_numeric($value) ? (int)$value : 0;
                if ($numValue > 0) { // Only log non-zero values
                    $fieldScores[$column] = $numValue;
                }
            }
            Log::info('Rumah Sakit Store - Field Scores Detail', [
                'non_zero_fields' => $fieldScores,
                'field_count' => count($fieldScores),
                'total_fields_available' => count($this->formPenilaianScoreFields())
            ]);

            $insert = RumahSakit::create($data);

            if (!$insert) {
                return redirect()->back()->with('error', 'Penilaian / inspeksi Rumah Sakit gagal dibuat, silahkan coba lagi')->withInput();
            }

            $message = $request->input('action') == 'duplicate' ? 'Duplikat penilaian / inspeksi Rumah Sakit berhasil dibuat' : 'Penilaian / inspeksi Rumah Sakit berhasil dibuat';
            return redirect(route('rumah-sakit.show', ['rumah_sakit' => $insert->id]))->with('success', $message);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed in store method', [
                'errors' => $e->errors(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorList = [];
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    $errorList[] = $message;
                }
            }
            
            // Create detailed error information for logging and display
            $errorDetails = [
                'Error Type' => 'Validation Error (Store)',
                'Error Message' => 'Field yang belum diisi dengan benar: ' . implode(', ', $errorList),
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Code' => $e->getCode(),
                'Fields' => json_encode($e->errors(), JSON_PRETTY_PRINT)
            ];
            
            $errorText = "Validation Error Details (Store):\n";
            foreach ($errorDetails as $key => $value) {
                $errorText .= "{$key}: {$value}\n";
            }
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error_details', $errorText)
                ->with('error', 'Terjadi kesalahan validasi. Lihat detail error di bawah.');
                
        } catch (\Exception $e) {
            Log::error('Error creating rumah sakit', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Create detailed error information for logging and display
            $errorDetails = [
                'Error Type' => 'General Error (Store)',
                'Error Message' => $e->getMessage(),
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Code' => $e->getCode()
            ];
            
            $errorText = "General Error Details (Store):\n";
            foreach ($errorDetails as $key => $value) {
                $errorText .= "{$key}: {$value}\n";
            }
            
            return redirect()->back()
                ->with('error_details', $errorText)
                ->with('error', 'Terjadi kesalahan saat menyimpan data. Lihat detail error di bawah.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RumahSakit $rumahSakit)
    {
        return view('pages.inspection.show', [
            'page_name' => 'history',
            'form_data' => $rumahSakit,
            'general_info' => $this->informasiUmum(),
            'inspection_name' => 'Rumah Sakit',
            'edit_route' => route('rumah-sakit.edit', ['rumah_sakit' => $rumahSakit['id']]),
            'destroy_route' => route('rumah-sakit.destroy', ['rumah_sakit' => $rumahSakit['id']]),
            'export_route' => route(
                'rumah-sakit.index',
                [
                    'export' => 'pdf',
                    'id' => $rumahSakit['id']],
            )]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RumahSakit $rumahSakit)
    {
        return view('pages.inspection.rumah-sakit.edit', [
            'page_name' => 'history',
            'informasi_umum' => $this->informasiUmum(),
            'form_penilaian' => $this->formPenilaian(),
            'form_data' => $rumahSakit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RumahSakit $rumahSakit)
    {
        try {
            // Validasi input dengan custom error messages
            $request->validate([
                'subjek' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kecamatan' => 'required|string|max:255',
                'kelurahan' => 'required|string|max:255',
                'kelas' => 'required|string|max:255',
                'jumlah-tempat-tidur' => 'required|numeric|min:1',
                'pengelola' => 'required|string|max:255',
                'kontak' => 'required|string|max:255',
                'nama-pemeriksa' => 'required|string|max:255',
                'instansi-pemeriksa' => 'required|string|max:255',
                'tanggal-penilaian' => 'required|date',
                'koordinat' => 'required|string|regex:/^-?\d+\.?\d*,\s*-?\d+\.?\d*$/',
                'status-operasi' => 'required|in:0,1',
                'dokumen-rintek-tps-b3' => 'required|in:Ya,Tidak',
                'nomor-dokumen-rintek-tps-b3' => 'nullable|string|max:255',
                'dokumen-pertek-ipal' => 'required|in:Ya,Tidak',
                'nomor-dokumen-pertek-ipal' => 'nullable|string|max:255',
                'pengisian-sikelim' => 'required|in:Ya,Tidak',
                'alasan-sikelim' => 'nullable|string|max:500',
                'pengisian-dsmiling' => 'required|in:Ya,Tidak',
                'alasan-dsmiling' => 'nullable|string|max:500',
                
                // Validasi field keterangan baru
                'keterangan_pihak_ketiga_jasa_boga' => 'nullable|string|max:255',
                'jumlah_penjamah_pangan' => 'nullable|integer|min:0',
                'jumlah_penjamah_bersertifikat' => 'nullable|integer|min:0',
                'keterangan_pihak_ketiga_pest_control' => 'nullable|string|max:255',
                'nomor_perizinan_pest_control' => 'nullable|string|max:255',
                'keterangan_pihak_ketiga_b3' => 'nullable|string|max:500',
                'nomor_perizinan_tps_b3' => 'nullable|string|max:255',
                'nomor_perizinan_ipal' => 'nullable|string|max:255',
                'memiliki_alat_rontgen_portable' => 'nullable|in:0,1',
                'memiliki_shielding_radiasi' => 'nullable|in:0,1',
                
                // Validasi field penilaian utama
                '1001' => 'nullable|in:0,25,50,100',
                '1002a' => 'nullable|in:0,400',
                '1002b' => 'nullable|in:0,400',
                '1002c' => 'nullable|in:0,100',
                '1003' => 'nullable|in:0,50,100',
                '1004' => 'nullable|in:0,50,100',
            ]);

            // Check if this is a duplicate action
            if ($request->input('action') == 'duplicate') {
                // For duplicate, get all data from request like RestoranController
                $data = $request->all();
                
                // Handle instansi-lainnya logic
                if (isset($data['instansi-pemeriksa']) && $data['instansi-pemeriksa'] === 'Lainnya' && isset($data['instansi-lainnya'])) {
                    $data['instansi-pemeriksa'] = $data['instansi-lainnya'];
                    unset($data['instansi-lainnya']);
                }
                
                // Add user ID for duplicate action
                $data['user_id'] = Auth::id();

                // Add form penilaian scores with proper defaults
                foreach ($this->formPenilaianName() as $column) {
                    // For selectc fields (1002a, 1002b, 1002c), use exact request value if present
                    if (in_array($column, ['1002a', '1002b', '1002c']) && $request->has($column)) {
                        $data[$column] = $request->input($column);
                    } else {
                        $defaultValue = $this->getDefaultValueForField($column);
                        $data[$column] = $request->input($column, $defaultValue);
                    }
                }
                
                // Handle special fields with specific handling - take exact value from request
                
                if ($request->has('9003')) {
                    $data['9003'] = $request->input('9003');
                } else {
                    $data['9003'] = $this->getDefaultValueForField('9003');
                }
                

                
                if ($request->has('memiliki_alat_rontgen_portable')) {
                    $data['memiliki_alat_rontgen_portable'] = $request->input('memiliki_alat_rontgen_portable');
                }
                if ($request->has('memiliki_shielding_radiasi')) {
                    $data['memiliki_shielding_radiasi'] = $request->input('memiliki_shielding_radiasi');
                }
                
                // Set default values for dokumen fields (default: tidak)
                $data['dokumen-rintek-tps-b3'] = $request->input('dokumen-rintek-tps-b3', 'Tidak');
                $data['dokumen-pertek-ipal'] = $request->input('dokumen-pertek-ipal', 'Tidak');
                
                // Set default values for pengisian fields (default: ya)
                $data['pengisian-sikelim'] = $request->input('pengisian-sikelim', 'Ya');
                $data['pengisian-dsmiling'] = $request->input('pengisian-dsmiling', 'Ya');
                
                // Add nomor dokumen fields
                $data['nomor-dokumen-rintek-tps-b3'] = $request->input('nomor-dokumen-rintek-tps-b3');
                $data['nomor-dokumen-pertek-ipal'] = $request->input('nomor-dokumen-pertek-ipal');
                
                // Add alasan fields
                $data['alasan-sikelim'] = $request->input('alasan-sikelim');
                $data['alasan-dsmiling'] = $request->input('alasan-dsmiling');
                
                // Calculate raw score and normalize to 10,000 based on max score 11,200
                $totalScoreObtained = array_reduce($this->formPenilaianScoreFields(), function($carry, $column) use ($request) {
                    $value = $request->input($column, 0);
                    return $carry + (is_numeric($value) ? (int)$value : 0);
                }, 0);
                // Normalize raw score to 10,000 with max score 11,200
                $normalizedScore = round(($totalScoreObtained / 11200) * 10000);
                $data['skor'] = $normalizedScore;

                // Log total score for debugging - Duplicate action
                Log::info('Rumah Sakit Update (Duplicate) - Total Score Calculated', [
                    'action' => 'duplicate',
                    'raw_score' => $totalScoreObtained,
                    'normalized_score' => $normalizedScore,
                    'max_raw_score' => 11200,
                    'max_normalized_score' => 10000,
                    'percentage' => round(($totalScoreObtained / 11200) * 100, 2) . '%',
                    'category' => $normalizedScore >= 8600 ? 'Sangat Baik' : ($normalizedScore >= 6500 ? 'Baik' : 'Kurang'),
                    'user_id' => Auth::id(),
                    'original_id' => $rumahSakit->id,
                    'subjek' => $request->input('subjek')
                ]);

                // For duplicate, preserve the original values if current values are empty
                if (empty($data['kelurahan']) && !empty($rumahSakit->kelurahan)) {
                    $data['kelurahan'] = $rumahSakit->kelurahan;
                }
                if (empty($data['kecamatan']) && !empty($rumahSakit->kecamatan)) {
                    $data['kecamatan'] = $rumahSakit->kecamatan;
                }
                if (empty($data['subjek']) && !empty($rumahSakit->subjek)) {
                    $data['subjek'] = $rumahSakit->subjek;
                }
                if (empty($data['alamat']) && !empty($rumahSakit->alamat)) {
                    $data['alamat'] = $rumahSakit->alamat;
                }

                // Remove action from data before create
                unset($data['action']);

                $insert = RumahSakit::create($data);

                if (!$insert) {
                    return redirect(route('inspection'))->with('error', 'penilaian / inspeksi Rumah Sakit gagal dibuat, silahkan coba lagi');
                }

                return redirect(route('rumah-sakit.show', ['rumah_sakit' => $insert->id]))->with('success', 'penilaian / inspeksi Rumah Sakit berhasil dibuat');
            }

            // For regular update, get validated data only
            $data = $request->only([
                'subjek', 'alamat', 'kecamatan', 'kelurahan', 'kelas', 'jumlah-tempat-tidur',
                'pengelola', 'kontak', 'nama-pemeriksa', 'instansi-pemeriksa', 'tanggal-penilaian',
                'koordinat', 'status-operasi', 'dokumen-rintek-tps-b3', 'nomor-dokumen-rintek-tps-b3',
                'dokumen-pertek-ipal', 'nomor-dokumen-pertek-ipal', 'pengisian-sikelim',
                'pengisian-dsmiling',
                'pelaporan-elektronik', 'pengamanan-radiasi', 'penyehatan-air-hemodiolisa',
                'catatan-lain', 'rencana-tindak-lanjut'
            ]);

            if ($request->input('action') == 'duplicate') {
                return $this->handleDuplicate($request, $rumahSakit);
            }

            // Process data for update
            $data = $this->processUpdateData($request);
            
            // Calculate raw score and normalize to 10,000 based on max score 11,200
            $totalScoreObtained = array_reduce($this->formPenilaianScoreFields(), function($carry, $column) use ($request) {
                $value = $request->input($column, 0);
                return $carry + (is_numeric($value) ? (int)$value : 0);
            }, 0);
            // Normalize raw score to 10,000 with max score 11,200
            $normalizedScore = round(($totalScoreObtained / 11200) * 10000);
            $data['skor'] = $normalizedScore;

            // Log total score for debugging - Update action
            Log::info('Rumah Sakit Update - Total Score Calculated', [
                'action' => 'update',
                'raw_score' => $totalScoreObtained,
                'normalized_score' => $normalizedScore,
                'max_raw_score' => 11200,
                'max_normalized_score' => 10000,
                'percentage' => round(($totalScoreObtained / 11200) * 100, 2) . '%',
                'category' => $normalizedScore >= 8600 ? 'Sangat Baik' : ($normalizedScore >= 6500 ? 'Baik' : 'Kurang'),
                'user_id' => Auth::id(),
                'rumah_sakit_id' => $rumahSakit->id,
                'subjek' => $request->input('subjek'),
                'old_score' => $rumahSakit->skor ?? 'not_set'
            ]);

            $update = $rumahSakit->update($data);

            if (!$update) {
                return redirect()->back()->with('error', 'Form informasi dan penilaian Rumah Sakit gagal diubah')->withInput();
            }

            // Clear application cache to ensure fresh data is loaded
            Artisan::call('cache:clear');
            Artisan::call('view:clear');

            return redirect(route('rumah-sakit.show', ['rumah_sakit' => $rumahSakit['id']]))->with('success', 'Form informasi dan penilaian Rumah Sakit berhasil diubah');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed in update method', [
                'errors' => $e->errors(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorList = [];
            foreach ($e->errors() as $messages) {
                foreach ($messages as $message) {
                    $errorList[] = $message;
                }
            }
            
            // Create detailed error information for logging and display
            $errorDetails = [
                'Error Type' => 'Validation Error (Update)',
                'Error Message' => 'Field yang belum diisi dengan benar: ' . implode(', ', $errorList),
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Code' => $e->getCode(),
                'Fields' => json_encode($e->errors(), JSON_PRETTY_PRINT)
            ];
            
            $errorText = "Validation Error Details (Update):\n";
            foreach ($errorDetails as $key => $value) {
                $errorText .= "{$key}: {$value}\n";
            }
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error_details', $errorText)
                ->with('error', 'Terjadi kesalahan validasi. Lihat detail error di bawah.');
                
        } catch (\Exception $e) {
            Log::error('Error updating rumah sakit', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Create detailed error information for logging and display
            $errorDetails = [
                'Error Type' => 'General Error (Update)',
                'Error Message' => $e->getMessage(),
                'File' => $e->getFile(),
                'Line' => $e->getLine(),
                'Code' => $e->getCode()
            ];
            
            $errorText = "General Error Details (Update):\n";
            foreach ($errorDetails as $key => $value) {
                $errorText .= "{$key}: {$value}\n";
            }
            
            return redirect()->back()
                ->with('error_details', $errorText)
                ->with('error', 'Terjadi kesalahan saat memperbarui data. Lihat detail error di bawah.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        $rumahSakit = RumahSakit::where('id', $id)->withTrashed()->first();

        if ($rumahSakit['deleted_at']) {
            $rumahSakit->update([
                'deleted_at' => null]);
            return redirect(route('archived'))->with('success', 'form inspeksi berhasil dipulihkan');
        }

        $rumahSakit->delete();

        return redirect(route('history'))->with('success', 'form informasi dan penilaian Rumah Sakit berhasil dihapus');
    }

    /**
     * Handle duplicate operation
     */
    private function handleDuplicate(Request $request, RumahSakit $rumahSakit)
    {
        // Get all request data for duplicate
        $data = $request->all();
        
        // Add user ID
        $data['user_id'] = Auth::id();

        // Process penilaian columns with proper defaults
        foreach ($this->formPenilaianName() as $column) {
            // For selectc fields (1002a, 1002b, 1002c), use exact request value if present
            if (in_array($column, ['1002a', '1002b', '1002c']) && $request->has($column)) {
                $data[$column] = $request->input($column);
            } else {
                $defaultValue = $this->getDefaultValueForField($column);
                $data[$column] = $request->input($column, $defaultValue);
            }
        }
        
        // Set default values
        $data['dokumen-rintek-tps-b3'] = $request->input('dokumen-rintek-tps-b3', 'Tidak');
        $data['dokumen-pertek-ipal'] = $request->input('dokumen-pertek-ipal', 'Tidak');
        $data['pengisian-sikelim'] = $request->input('pengisian-sikelim', 'Ya');
        $data['pengisian-dsmiling'] = $request->input('pengisian-dsmiling', 'Ya');
        
        // Add nomor dokumen fields
        $data['nomor-dokumen-rintek-tps-b3'] = $request->input('nomor-dokumen-rintek-tps-b3');
        $data['nomor-dokumen-pertek-ipal'] = $request->input('nomor-dokumen-pertek-ipal');
        
        // Add alasan fields
        $data['alasan-sikelim'] = $request->input('alasan-sikelim');
        $data['alasan-dsmiling'] = $request->input('alasan-dsmiling');
        
        // Preserve original values if current values are empty
        if (empty($data['kelurahan']) && !empty($rumahSakit->kelurahan)) {
            $data['kelurahan'] = $rumahSakit->kelurahan;
        }
        if (empty($data['kecamatan']) && !empty($rumahSakit->kecamatan)) {
            $data['kecamatan'] = $rumahSakit->kecamatan;
        }
        if (empty($data['subjek']) && !empty($rumahSakit->subjek)) {
            $data['subjek'] = $rumahSakit->subjek;
        }
        if (empty($data['alamat']) && !empty($rumahSakit->alamat)) {
            $data['alamat'] = $rumahSakit->alamat;
        }
        
        // Calculate raw score and normalize to 10,000
        $totalScoreObtained = array_reduce($this->formPenilaianScoreFields(), function($carry, $column) use ($request) {
            $value = $request->input($column, 0);
            return $carry + (is_numeric($value) ? (int)$value : 0);
        }, 0);
        // Normalize raw score to 10,000 with cap to prevent exceeding maximum
        $normalizedScore = min(10000, round(($totalScoreObtained / 10000) * 10000));
        $data['skor'] = $normalizedScore;

        $insert = RumahSakit::create($data);

        if (!$insert) {
            return redirect(route('inspection'))->with('error', 'penilaian / inspeksi Rumah Sakit gagal dibuat, silahkan coba lagi');
        }

        return redirect(route('rumah-sakit.show', ['rumah_sakit' => $insert->id]))->with('success', 'penilaian / inspeksi Rumah Sakit berhasil dibuat');
    }

    /**
     * Process data for update operation
     */
    private function processUpdateData(Request $request)
    {
        $data = [];
        
        // Basic fields
        $basicFields = [
            'nama-rumah-sakit', 'alamat', 'kelurahan', 'kecamatan', 'subjek',
            'pelaporan-elektronik', 'dokumen-izin-rs', 'no-izin-rs', 'tgl-izin-rs',
            'dokumen-akreditasi', 'masa-berlaku-akreditasi', 'no-akreditasi'
        ];
        
        foreach ($basicFields as $field) {
            $data[$field] = $request->input($field);
        }
        
        // Penilaian fields with proper defaults
        foreach ($this->formPenilaianName() as $column) {
            // For selectc fields (1002a, 1002b, 1002c), use exact request value if present
            if (in_array($column, ['1002a', '1002b', '1002c']) && $request->has($column)) {
                $data[$column] = $request->input($column);
            } else {
                $defaultValue = $this->getDefaultValueForField($column);
                $data[$column] = $request->input($column, $defaultValue);
            }
        }
        
        // Handle special fields with specific handling - take exact value from request
        
        if ($request->has('9003')) {
            $data['9003'] = $request->input('9003');
        } else {
            $data['9003'] = $this->getDefaultValueForField('9003');
        }
        
        if ($request->has('memiliki_alat_rontgen_portable')) {
            $data['memiliki_alat_rontgen_portable'] = $request->input('memiliki_alat_rontgen_portable');
        }
        if ($request->has('memiliki_shielding_radiasi')) {
            $data['memiliki_shielding_radiasi'] = $request->input('memiliki_shielding_radiasi');
        }
        
        // Set default values for dokumen fields
        $data['dokumen-rintek-tps-b3'] = $request->input('dokumen-rintek-tps-b3', 'Tidak');
        $data['dokumen-pertek-ipal'] = $request->input('dokumen-pertek-ipal', 'Tidak');
        
        // Set default values for pengisian fields
        $data['pengisian-sikelim'] = $request->input('pengisian-sikelim', 'Ya');
        $data['pengisian-dsmiling'] = $request->input('pengisian-dsmiling', 'Ya');
        
        // Add nomor dokumen fields
        $data['nomor-dokumen-rintek-tps-b3'] = $request->input('nomor-dokumen-rintek-tps-b3');
        $data['nomor-dokumen-pertek-ipal'] = $request->input('nomor-dokumen-pertek-ipal');
        
        // Add alasan fields
        $data['alasan-sikelim'] = $request->input('alasan-sikelim');
        $data['alasan-dsmiling'] = $request->input('alasan-dsmiling');
        
        return $data;
    }


}
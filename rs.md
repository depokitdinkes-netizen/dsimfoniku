| #   | Nama                               | Jenis                       | Penyortiran         | Atribut   | Tak Ternilai | Bawaan     |
|-----|------------------------------------|-----------------------------|---------------------|-----------|--------------|------------|
| 1   | id                                 | bigint(20)                  |                     | UNSIGNED  | Tidak        | AUTO_INCREMENT |
| 2   | user_id                            | bigint(20)                  |                     | UNSIGNED  | Ya           | NULL       |
| 3   | subjek                             | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 4   | pengelola                          | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 5   | alamat                             | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 6   | kelurahan                          | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 7   | kelas                              | enum('A','B','C','D') utf8mb4_unicode_ci |         |           | Tidak        |            |
| 8   | kecamatan                          | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 9   | kontak                             | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 10  | status-operasi                     | enum('0','1') utf8mb4_unicode_ci |                |           | Tidak        |            |
| 11  | koordinat                          | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 12  | nama-pemeriksa                     | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 13  | instansi-pemeriksa                 | varchar(255) utf8mb4_unicode_ci |                 |           | Tidak        |            |
| 14  | tanggal-penilaian                  | date                        |                     |           | Tidak        |            |
| 15  | skor                               | int(11)                     |                     |           | Tidak        |            |
| 16  | pelaporan-elektronik               | text utf8mb4_unicode_ci     |                     |           | Tidak        |            |
| 17  | pengamanan-radiasi                 | text utf8mb4_unicode_ci     |                     |           | Tidak        |            |
| 18  | penyehatan-air-hemodiolisa         | text utf8mb4_unicode_ci     |                     |           | Tidak        |            |
| 19  | catatan-lain                       | text utf8mb4_unicode_ci     |                     |           | Ya           | NULL       |
| 20  | rencana-tindak-lanjut              | text utf8mb4_unicode_ci     |                     |           | Ya           | NULL       |
| 21  | dokumen-rintek-tps-b3              | enum('Ya','Tidak') utf8mb4_unicode_ci |           | Ya        | NULL         |
| 22  | nomor-dokumen-rintek-tps-b3        | varchar(255) utf8mb4_unicode_ci |                 | Ya        | NULL         |
| 23  | dokumen-pertek-ipal                | enum('Ya','Tidak') utf8mb4_unicode_ci |           | Ya        | NULL         |
| 24  | nomor-dokumen-pertek-ipal          | varchar(255) utf8mb4_unicode_ci |                 | Ya        | NULL         |
| 25  | pengisian-sikelim                  | enum('Ya','Tidak') utf8mb4_unicode_ci |           | Ya        | NULL         |
| 26  | alasan-sikelim                     | text utf8mb4_unicode_ci     |                     | Ya        | NULL         |
| 27  | pengisian-dsmiling                 | enum('Ya','Tidak') utf8mb4_unicode_ci |           | Ya        | NULL         |
| 28  | alasan-dsmiling                    | text utf8mb4_unicode_ci     |                     | Ya        | NULL         |
| 29  | created_at                         | timestamp                   |                     |           | Ya           | NULL       |
| 30  | updated_at                         | timestamp                   |                     |           | Ya           | NULL       |
| 31  | deleted_at                         | timestamp                   |                     |           | Ya           | NULL       |
| 32  | jumlah-tempat-tidur                | int(11)                     |                     |           | Tidak        |            |
| 33  | 1001                               | int(11)                     |                     |           | Tidak        | 0          |
| 34  | 1002a                              | int(11)                     |                     |           | Ya           | 0          |
| 35  | 1002b                              | int(11)                     |                     |           | Ya           | 0          |
| 36  | 1002c                              | int(11)                     |                     |           | Ya           | 0          |
| 37  | 1003                               | int(11)                     |                     |           | Tidak        | 0          |
| 38  | 1004                               | int(11)                     |                     |           | Tidak        | 0          |
| 39  | 2001a                              | int(11)                     |                     |           | Tidak        | 0          |
| 40  | 2001b                              | int(11)                     |                     |           | Tidak        | 0          |
| 41  | 2002                               | int(11)                     |                     |           | Tidak        | 0          |
| 42  | 2003a                              | int(11)                     |                     |           | Tidak        | 0          |
| 43  | 2003b                              | int(11)                     |                     |           | Tidak        | 0          |
| 44  | 2003c                              | int(11)                     |                     |           | Tidak        | 0          |
| 45  | 2003d                              | int(11)                     |                     |           | Tidak        | 0          |
| 46  | 2003e                              | int(11)                     |                     |           | Tidak        | 0          |
| 47  | 2003f                              | int(11)                     |                     |           | Tidak        | 0          |
| 48  | 2003g                              | int(11)                     |                     |           | Tidak        | 0          |
| 49  | 2003h                              | int(11)                     |                     |           | Tidak        | 0          |
| 50  | 2003i                              | int(11)                     |                     |           | Tidak        | 0          |
| 51  | 2003j                              | int(11)                     |                     |           | Tidak        | 0          |
| 52  | 2003k                              | int(11)                     |                     |           | Tidak        | 0          |
| 53  | 2004a                              | int(11)                     |                     |           | Tidak        | 0          |
| 54  | 2004b                              | int(11)                     |                     |           | Tidak        | 0          |
| 55  | 2004c                              | int(11)                     |                     |           | Tidak        | 0          |
| 56  | 2004d                              | int(11)                     |                     |           | Tidak        | 0          |
| 57  | 2004e                              | int(11)                     |                     |           | Tidak        | 0          |
| 58  | 2004f                              | int(11)                     |                     |           | Tidak        | 0          |
| 59  | 2004g                              | int(11)                     |                     |           | Tidak        | 0          |
| 60  | 2004h                              | int(11)                     |                     |           | Tidak        | 0          |
| 61  | 2004i                              | int(11)                     |                     |           | Tidak        | 0          |
| 62  | 2004j                              | int(11)                     |                     |           | Tidak        | 0          |
| 63  | 2004k                              | int(11)                     |                     |           | Tidak        | 0          |
| 64  | 2004l                              | int(11)                     |                     |           | Tidak        | 0          |
| 65  | 2004m                              | int(11)                     |                     |           | Tidak        | 0          |
| 66  | 2004n                              | int(11)                     |                     |           | Tidak        | 0          |
| 67  | 2004o                              | int(11)                     |                     |           | Tidak        | 0          |
| 68  | 2004p                              | int(11)                     |                     |           | Tidak        | 0          |
| 69  | 2005a                              | int(11)                     |                     |           | Tidak        | 0          |
| 70  | 2005b                              | int(11)                     |                     |           | Tidak        | 0          |
| 71  | 2005c                              | int(11)                     |                     |           | Tidak        | 0          |
| 72  | 2005d                              | int(11)                     |                     |           | Tidak        | 0          |
| 73  | 2005e                              | int(11)                     |                     |           | Tidak        | 0          |
| 74  | 2005f                              | int(11)                     |                     |           | Tidak        | 0          |
| 75  | 2005g                              | int(11)                     |                     |           | Tidak        | 0          |
| 76  | 2005h                              | int(11)                     |                     |           | Tidak        | 0          |
| 77  | 2005i                              | int(11)                     |                     |           | Tidak        | 0          |
| 78  | 3001                               | int(11)                     |                     |           | Tidak        | 0          |
| 79  | keterangan_pihak_ketiga_jasa_boga  | text utf8mb4_unicode_ci     |                     |           | Ya           | NULL       |
| 80  | jumlah_penjamah_pangan             | int(11)                     |                     |           | Ya           | NULL       |
| 81  | jumlah_penjamah_bersertifikat      | int(11)                     |                     |           | Ya           | NULL       |
| 82  | 3002                               | int(11)                     |                     |           | Tidak        | 0          |
| 83  | 4001                               | int(11)                     |                     |           | Tidak        | 0          |
| 84  | 4002                               | int(11)                     |                     |           | Tidak        | 0          |
| 85  | 4003a                              | int(11)                     |                     |           | Tidak        | 0          |
| 86  | 4003b                              | int(11)                     |                     |           | Tidak        | 0          |
| 87  | 4003c                              | int(11)                     |                     |           | Tidak        | 0          |
| 88  | 4003d                              | int(11)                     |                     |           | Tidak        | 0          |
| 89  | 4004a                              | int(11)                     |                     |           | Tidak        | 0          |
| 90  | 4004b                              | varchar(255) utf8mb4_unicode_ci |                 | Ya        | NULL         |
| 91  | 4004c                              | int(11)                     |                     |           | Tidak        | 0          |
| 92  | 4004d                              | int(11)                     |                     |           | Tidak        | 0          |
| 93  | 4004e                              | int(11)                     |                     |           | Tidak        | 0          |
| 94  | 4004f                              | int(11)                     |                     |           | Tidak        | 0          |
| 95  | 4005                               | int(11)                     |                     |           | Tidak        | 0          |
| 96  | 4006a                              | int(11)                     |                     |           | Tidak        | 0          |
| 97  | 4006b                              | int(11)                     |                     |           | Tidak        | 0          |
| 98  | 4006c                              | int(11)                     |                     |           | Tidak        | 0          |
| 99  | 4006d                              | int(11)                     |                     |           | Tidak        | 0          |
| 100 | 4006e                              | int(11)                     |                     |           | Tidak        | 0          |
| 101 | 5001a                              | int(11)                     |                     |           | Tidak        | 0          |
| 102 | 5001b                              | int(11)                     |                     |           | Tidak        | 0          |
| 103 | 5001c                              | int(11)                     |                     |           | Tidak        | 0          |
| 104 | 5001d                              | int(11)                     |                     |           | Tidak        | 0          |
| 105 | 5001e                              | int(11)                     |                     |           | Tidak        | 0          |
| 106 | 5001f                              | int(11)                     |                     |           | Tidak        | 0          |
| 107 | 5001g                              | int(11)                     |                     |           | Tidak        | 0          |
| 108 | 5001h                              | int(11)                     |                     |           | Tidak        | 0          |
| 109 | 5001i                              | int(11)                     |                     |           | Tidak        | 0          |
| 110 | 5001j                              | int(11)                     |                     |           | Tidak        | 0          |
| 111 | keterangan_pihak_ketiga_pest_control | text utf8mb4_unicode_ci   |                     |           | Ya           | NULL       |
| 112 | nomor_perizinan_pest_control       | text utf8mb4_unicode_ci     |                     |           | Ya           | NULL       |
| 113 | 5002                               | int(11)                     |                     |           | Tidak        | 0          |
| 114 | 6001a                              | int(11)                     |                     |           | Tidak        | 0          |
| 115 | 6001b                              | int(11)                     |                     |           | Tidak        | 0          |
| 116 | 6001c                              | int(11)                     |                     |           | Tidak        | 0          |
| 117 | 6002a                              | int(11)                     |                     |           | Tidak        | 0          |
| 118 | 6002b                              | int(11)                     |                     |           | Tidak        | 0          |
| 119 | 6002c                              | int(11)                     |                     |           | Tidak        | 0          |
| 120 | 6002d                              | int(11)                     |                     |           | Tidak        | 0          |
| 121 | keterangan_pihak_ketiga_b3         | text utf8mb4_unicode_ci     |                     |           | Ya           | NULL       |
| 122 | nomor_perizinan_tps_b3             | text utf8mb4_unicode_ci     |                     |           | Ya           | NULL       |
| 123 | 6003a                              | int(11)                     |                     |           | Tidak        | 0          |
| 124 | 6003b                              | int(11)                     |                     |           | Tidak        | 0          |
| 125 | nomor_perizinan_ipal               | text utf8mb4_unicode_ci     |                     |           | Ya           | NULL       |
| 126 | 6004a                              | int(11)                     |                     |           | Tidak        | 0          |
| 127 | 6004b                              | int(11)                     |                     |           | Tidak        | 0          |
| 128 | 6004c                              | int(11)                     |                     |           | Tidak        | 0          |
| 129 | 6004d                              | int(11)                     |                     |           | Tidak        | 0          |
| 130 | 6004e                              | int(11)                     |                     |           | Tidak        | 0          |
| 131 | 7001                               | int(11)                     |                     |           | Tidak        | 0          |
| 132 | 7002                               | int(11)                     |                     |           | Tidak        | 0          |
| 133 | 7003                               | int(11)                     |                     |           | Tidak        | 0          |
| 134 | memiliki_alat_rontgen_portable     | tinyint(1)                  |                     |           | Ya           | NULL       |
| 135 | memiliki_shielding_radiasi         | tinyint(1)                  |                     |           | Ya           | NULL       |
| 136 | 8001a                              | int(11)                     |                     |           | Tidak        | 0          |
| 137 | 8001b                              | int(11)                     |                     |           | Tidak        | 0          |
| 138 | 8001c                              | int(11)                     |                     |           | Tidak        | 0          |
| 139 | 8001d                              | int(11)                     |                     |           | Tidak        | 0          |
| 140 | 8001e                              | int(11)                     |                     |           | Tidak        | 0          |
| 141 | 8002a                              | int(11)                     |                     |           | Tidak        | 0          |
| 142 | 8002b                              | int(11)                     |                     |           | Tidak        | 0          |
| 143 | 9001a                              | int(11)                     |                     |           | Tidak        | 0          |
| 144 | 9001b                              | int(11)                     |                     |           | Tidak        | 0          |
| 145 | 9001c                              | int(11)                     |                     |           | Tidak        | 0          |
| 146 | 9001d                              | int(11)                     |                     |           | Tidak        | 0          |
| 147 | 9001e                              | int(11)                     |                     |           | Tidak        | 0          |
| 148 | 9001f                              | int(11)                     |                     |           | Tidak        | 0          |
| 149 | 9002                               | int(11)                     |                     |           | Tidak        | 0          |
| 150 | 9003                               | int(11)                     |                     |           | Tidak        | 0          |
| 151 | 7004                               | int(11)                     |                     |           | Ya           | NULL       |
| 152 | 7005                               | int(11)                     |                     |           | Ya           | NULL       |

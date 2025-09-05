<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserKelurahan;
use App\Models\FormIKL\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'fullname' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('passwordnyabukanpassword'),
            'role' => 'SUPERADMIN',
            'sizebaris1' => '20px',
            'baris1' => 'PEMERINTAHAN KOTA DEPOK',
            'sizebaris2' => '37px',
            'baris2' => 'DINAS KESEHATAN',
            'sizebaris3' => '15px',
            'baris3' => 'Jl. Margonda Raya No. 54, Gedung DIBALEKA II Lt.3',
            'sizebaris4' => '15px',
            'baris4' => 'Telp : (021) 29402281 DEPOK 16431',
        ]);

        $adminSukamaju = User::create([
            'fullname' => 'Admin Puskesmas Sukamaju',
            'email' => 'admin.sukamaju@gmail.com',
            'password' => Hash::make('admin12345'),
            'role' => 'ADMIN',
            'sizebaris1' => '18px',
            'baris1' => 'PEMERINTAHAN KOTA DEPOK',
            'sizebaris2' => '30px',
            'baris2' => 'PUSKESMAS SUKAMAJU',
            'sizebaris3' => '13px',
            'baris3' => 'Jl. Sukamaju No. 10, Depok',
            'sizebaris4' => '13px',
            'baris4' => 'Telp : (021) 12345678 DEPOK 16431',
            'sizebaris5' => '13px',
            'baris5' => 'Email: sukamaju@puskesmas.depok.go.id',
        ]);

        // Add multiple kelurahan for admin Sukamaju
        UserKelurahan::create([
            'user_id' => $adminSukamaju->id,
            'kelurahan' => 'Sukamaju Baru',
            'kecamatan' => 'Tapos'
        ]);

        UserKelurahan::create([
            'user_id' => $adminSukamaju->id,
            'kelurahan' => 'Jatijajar',
            'kecamatan' => 'Tapos'
        ]);

        UserKelurahan::create([
            'user_id' => $adminSukamaju->id,
            'kelurahan' => 'Cilodong',
            'kecamatan' => 'Tapos'
        ]);

        // Sample data sekolah
        
        // Run IKL inspection seeder
        $this->call([
            SekolahSeeder::class,
            IklInspectionSeeder::class,
        ]);
    }
}

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
            'email' => 'super@gmail.com',
            'password' => Hash::make('123456'),
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


        // Sample data sekolah
        
        // Run IKL inspection seeder
        $this->call([
            SekolahSeeder::class,
            IklInspectionSeeder::class,
        ]);
    }
}

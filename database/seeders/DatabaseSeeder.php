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

        
        // Run IKL inspection seeder
        $this->call([
            SekolahSeeder::class,
            IklInspectionSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdiSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        DB::table('study_programs')->insert([
            ['program_name' => 'D4 Bisnis Digital'],
            ['program_name' => 'D4 Akuntansi Bisnis Digital'],
            ['program_name' => 'D4 Manajemen Pemasaran Internasional'],
            ['program_name' => 'D4 Teknologi Rekayasa Multimedia'],
            ['program_name' => 'D3 Teknik Informatika'],
            ['program_name' => 'D3 Teknik Otomotif'],
            ['program_name' => 'D3 Budidaya Tanaman Perkebunan'],
        ]);
    }
}

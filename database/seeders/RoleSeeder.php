<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // bikin role admin & camaba (kalau belum ada)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $camabaRole = Role::firstOrCreate(['name' => 'camaba']);

        // buat user admin default kalau belum ada
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('polhas116'),
            ]
             );
        $camaba = User::firstOrCreate(
            ['email' => 'camaba@gmail.com'],
            [
                'name' => 'camaba',
                'password' => Hash::make('camaba123'),
            ]
            );
        

        // kasih role admin
        $admin->assignRole($adminRole);
        $camaba->assignRole($camabaRole);
    }
}

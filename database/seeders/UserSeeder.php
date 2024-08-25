<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Pastikan role superadmin sudah ada
        $role = Role::firstOrCreate(['name' => 'superadmin']);

        // Membuat user baru dengan role superadmin
        User::create([
            'name' => 'Wahyu Cahyo',
            'email' => 'wahyu@gmail.com',
            'password' => Hash::make('11111111'), // Ganti dengan password yang diinginkan
            'phone_number' => '6288888888',
            'photo' => '', // Ganti dengan nama file foto jika ada
            'role' => 'superadmin',
        ])->assignRole($role); // Menetapkan role kepada user
    }
}


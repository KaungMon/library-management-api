<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'admin',
                'first_name' => 'admin',
                'surname' => 'power',
                'address' => '1 Wall Street Court',
                'phone' => '091212122',
                'gender' => 'M',
                'user_role_id' => 1,
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin12345')
            ],
        ]);
    }
}

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
                'username' => 'Baba Yaga',
                'first_name' => 'Jardani',
                'surname' => 'Jovonovich',
                'address' => '1 Wall Street Court',
                'phone' => '091212122',
                'gender' => 'M',
                'user_role_id' => 1,
                'email' => 'johnwick@gmail.com',
                'password' => Hash::make('johnwick1234567')
            ],
            [
                'username' => 'K2DaMooN',
                'first_name' => 'kaung mon',
                'surname' => 'aung',
                'address' => 'pyay',
                'phone' => '094237179',
                'gender' => 'M',
                'user_role_id' => 2,
                'email' => 'kaungmon@gmail.com',
                'password' => Hash::make('kaungmon1234567')
            ],
            [
                'username' => 'Raymond',
                'first_name' => 'Wai Mon',
                'surname' => 'Oo',
                'address' => 'Rangon',
                'phone' => '091212122',
                'gender' => 'M',
                'user_role_id' => 1,
                'email' => 'raymond@gmail.com',
                'password' => Hash::make('raymond1234567')
            ],
            [
                'username' => 'Hanni',
                'first_name' => 'phạm ngọc',
                'surname' => 'hân',
                'address' => 'korea',
                'phone' => '03434933',
                'gender' => 'F',
                'user_role_id' => 2,
                'email' => 'hanni@gmail.com',
                'password' => Hash::make('hanni1234567')
            ]
        ]);
    }
}

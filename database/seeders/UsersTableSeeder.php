<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'ユーザー1',
                'email' => 'a@a.com',
                'password' => Hash::make('aaaaaa')
            ],
            [
                'name' => 'ユーザー2',
                'email' => 'b@b.com',
                'password' => Hash::make('aaaaaa')
            ],
        ]);
        for ($i = 3; $i < 10; $i++) {
            DB::table('users')->insert([
                [
                    'name' =>  'ユーザー' . $i,
                    'email' => chr($i + 96) . '@' . chr($i + 96) . 'com',
                    'password' => Hash::make('aaaaaa')
                ],
            ]);
        };
    }
}
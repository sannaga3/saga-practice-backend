<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 23; $i++) {
            DB::table('posts')->insert([
                [
                    'title' =>  'タイトル' . $i,
                    'content' => Factory::create('ja_JP')->realText(50, 5),
                    'user_id' => floor($i / 3 + 1)
                ],
            ]);
        };
    }
}
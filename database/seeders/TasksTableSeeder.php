<?php

namespace Database\Seeders;

use Carbon\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 23; $i++) {
            DB::table('tasks')->insert([
                [
                    'name' => '筋トレを続ける' . $i,
                    'purpose' => '痩せたい',
                    'action' => '腹筋',
                    'target_times' => 1000,
                    'times_unit' => '回',
                    'schedule_start' => '2022-07-10',
                    'schedule_end' => '2022-08-10',
                    'remarks' => 'できるだけ毎日続ける',
                    'status' => '1',
                    'user_id' => floor($i / 3 + 1),
                ],
            ]);
        };
    }
}
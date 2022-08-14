<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExecutedTasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 10; $i++) {
            DB::table('executed_tasks')->insert([
                [
                    'times' =>  $i,
                    'date' => new DateTime('2022-07-0' . strval($i) . ' 00:00:00'),
                    'task_id' => floor($i / 4 + 19)
                ],
            ]);
        };
    }
}
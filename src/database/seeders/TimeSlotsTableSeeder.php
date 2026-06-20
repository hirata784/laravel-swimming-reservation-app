<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 6; $i++) {
            for ($j = 9; $j <= 18; $j++) {
                $param = [
                    'date' => Carbon::now()->addDays($i),
                    'start_time' => $j . ':00:00',
                    'capacity' => '25'
                ];
                DB::table('time_slots')->insert($param);
            }
        }
    }
}

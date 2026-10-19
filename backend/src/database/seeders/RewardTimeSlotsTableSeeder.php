<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardTimeSlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 特典追加用のダミーデータ
        for ($i = 2; $i >= 1; $i--) {
            for ($j = 9; $j <= 18; $j++) {
                // 00分
                $param = [
                    'date' => Carbon::now()->subDays($i),
                    'start_time' => $j . ':00:00',
                    'capacity' => '7'
                ];
                DB::table('time_slots')->insert($param);
                // 30分
                $param = [
                    'date' => Carbon::now()->subDays($i),
                    'start_time' => $j . ':30:00',
                    'capacity' => '7'
                ];
                DB::table('time_slots')->insert($param);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 特典追加用のダミーデータ
        for ($i = 1; $i <= 5; $i++) {
            for ($j = 141; $j <= 145; $j++) {
                $param = [
                    'user_id' => $i,
                    'time_slot_id' => $j,
                    'status' => 'used',
                ];
                DB::table('reservations')->insert($param);
            }
        }

        for ($i = 6; $i <= 10; $i++) {
            for ($j = 169; $j <= 173; $j++) {
                $param = [
                    'user_id' => $i,
                    'time_slot_id' => $j,
                    'status' => 'used',
                ];
                DB::table('reservations')->insert($param);
            }
        }
    }
}

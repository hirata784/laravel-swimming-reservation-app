<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => '1',
            'time_slot_id' => '1',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '1',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '24',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '28',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '42',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '55',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '120',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '120',
        ];
        DB::table('reservations')->insert($param);
    }
}

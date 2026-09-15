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
            'time_slot_id' => '43',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '65',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '75',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '87',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '132',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '2',
            'time_slot_id' => '30',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '43',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '87',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '88',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '127',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '3',
            'time_slot_id' => '43',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '65',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '87',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '88',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '127',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '4',
            'time_slot_id' => '43',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '47',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '64',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '65',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '88',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '5',
            'time_slot_id' => '28',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '36',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '46',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '47',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '127',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '6',
            'time_slot_id' => '43',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '88',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '115',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '127',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '133',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '7',
            'time_slot_id' => '36',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '65',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '87',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '88',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '132',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '8',
            'time_slot_id' => '43',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '65',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '88',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '127',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '132',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '9',
            'time_slot_id' => '30',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '47',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '65',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '87',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '127',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '10',
            'time_slot_id' => '30',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '43',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '47',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '88',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '127',
        ];
        DB::table('reservations')->insert($param);
    }
}

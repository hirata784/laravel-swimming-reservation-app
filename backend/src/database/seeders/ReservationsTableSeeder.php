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
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '65',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '75',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '87',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '1',
            'time_slot_id' => '132',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '2',
            'time_slot_id' => '30',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '43',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '87',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '88',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '2',
            'time_slot_id' => '127',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '3',
            'time_slot_id' => '43',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '65',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '87',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '88',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '3',
            'time_slot_id' => '127',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '4',
            'time_slot_id' => '43',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '47',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '64',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '65',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '4',
            'time_slot_id' => '88',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '5',
            'time_slot_id' => '28',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '36',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '46',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '47',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '5',
            'time_slot_id' => '127',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '6',
            'time_slot_id' => '43',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '88',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '115',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '127',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '6',
            'time_slot_id' => '133',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '7',
            'time_slot_id' => '36',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '65',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '87',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '88',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '7',
            'time_slot_id' => '132',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '8',
            'time_slot_id' => '43',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '65',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '88',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '127',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '8',
            'time_slot_id' => '132',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '9',
            'time_slot_id' => '30',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '47',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '65',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '87',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '9',
            'time_slot_id' => '127',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);

        $param = [
            'user_id' => '10',
            'time_slot_id' => '30',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '43',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '47',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '88',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
        $param = [
            'user_id' => '10',
            'time_slot_id' => '127',
            'status' => 'reserved',
        ];
        DB::table('reservations')->insert($param);
    }
}

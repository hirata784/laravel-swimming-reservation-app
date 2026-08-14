<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $param = [
            'name' => 'テスト一郎',
            'email' => 'ichiro@example.com',
            'password' => bcrypt('ichi1234'),
            'gender' => '男性',
            'address' => '神奈川県ほげほげ市ほげほげ1-2',
            'phone' => '0801234567',
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト二郎',
            'email' => 'jiro@example.com',
            'password' => bcrypt('jiro5678'),
            'gender' => '男性',
            'address' => '東京都ふがふが市ふがふが3-45',
            'phone' => '0902223333',
        ];
        DB::table('users')->insert($param);
    }
}

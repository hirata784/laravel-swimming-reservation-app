<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('ichi1234'),
            'gender' => '男性',
            'address' => '神奈川県横浜市西区みなとみらい2丁目',
            'phone' => '0801234567',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト二郎',
            'email' => 'jiro@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('jiro5678'),
            'gender' => '男性',
            'address' => '東京都千代田区丸の内1丁目',
            'phone' => '0902223333',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        DB::table('users')->insert($param);
    }
}

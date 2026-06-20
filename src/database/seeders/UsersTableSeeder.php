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
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => 'テスト二郎',
            'email' => 'jiro@example.com',
            'password' => bcrypt('jiro5678'),
        ];
        DB::table('users')->insert($param);
    }
}

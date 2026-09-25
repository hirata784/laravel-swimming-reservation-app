<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '管理者太郎',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin9999'),
        ];
        DB::table('admins')->insert($param);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'スポーツドリンク',
            'is_active' => true,
        ];
        DB::table('reward_items')->insert($param);
        $param = [
            'name' => '入浴剤',
            'is_active' => true,
        ];
        DB::table('reward_items')->insert($param);
        $param = [
            'name' => 'スキンケアセット',
            'is_active' => true,
        ];
        DB::table('reward_items')->insert($param);
        $param = [
            'name' => 'アミノ酸ゼリー',
            'is_active' => true,
        ];
        DB::table('reward_items')->insert($param);
        $param = [
            'name' => 'プロテインバー',
            'is_active' => true,
        ];
        DB::table('reward_items')->insert($param);
    }
}

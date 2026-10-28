<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardTicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            $param = [
                'user_id' => $i,
                'earned_at_uses' => 5,
            ];
            DB::table('reward_tickets')->insert($param);
        }
    }
}

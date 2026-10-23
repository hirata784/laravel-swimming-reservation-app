<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 古い環境から引っ越してきたシーダーの実行ロジック
        $this->call(UsersTableSeeder::class);
        User::factory()->count(8)->create();
        $this->call(TimeSlotsTableSeeder::class);
        $this->call(RewardTimeSlotsTableSeeder::class);
        $this->call(ReservationsTableSeeder::class);
        $this->call(RewardReservationsTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(RewardItemsTableSeeder::class);
        $this->call(RewardTicketsTableSeeder::class);
    }
}

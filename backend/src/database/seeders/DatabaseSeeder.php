<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
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

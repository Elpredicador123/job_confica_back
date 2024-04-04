<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Image;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
        ->hasBirthdays(1)
        ->hasNews(10)
        ->hasReservations(10)
        ->create();

        Image::factory(50)
        ->create();

        $this->call([
            ZoneSeeder::class,
            LineSeeder::class,
            TechnicalSeeder::class,
            EffectiveSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}

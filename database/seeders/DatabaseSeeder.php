<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Referee',
            'email' => 'referee',
            'password' => bcrypt('2022@Badmin7'),
            'type' => 'referee',
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Árbitro',
            'email' => 'arbitro',
            'password' => bcrypt('2022@Badmin7'),
            'type' => 'arbitro',
        ]);
    }
}

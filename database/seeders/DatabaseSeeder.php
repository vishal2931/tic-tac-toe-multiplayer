<?php

namespace Database\Seeders;

use App\Models\Lobby;
use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Lobbies
        Lobby::factory()->create();

        // Players
        Player::factory(2)->create();

    }
}

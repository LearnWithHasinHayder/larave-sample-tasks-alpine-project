<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a demo user with a known password
        $user = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create 10 tasks for the demo user
        Task::factory(10)->create([
            'user_id' => $user->id,
        ]);

        // Create a few more random users with tasks
        User::factory(3)->create()->each(function ($user) {
            Task::factory(5)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}

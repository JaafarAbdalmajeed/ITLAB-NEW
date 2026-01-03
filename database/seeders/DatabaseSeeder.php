<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
        // User::factory(10)->create();

        // Create or get test user to make seeding idempotent
        User::firstOrCreate(
    ['email' => 'student@com'],
    [
        'name'     => 'Test User',
        'password' => Hash::make('student.com308'),
    ]
);
        // Seed example tracks, lessons, quizzes, questions and labs
        $this->call([
            TrackSeeder::class,
            PageSeeder::class,
            AdminUserSeeder::class,
            NavbarItemSeeder::class,
        ]);
    }
}

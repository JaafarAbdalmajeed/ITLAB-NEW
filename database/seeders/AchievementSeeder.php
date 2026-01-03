<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'code' => 'first_lesson',
                'name_ar' => 'First Step',
                'name_en' => 'First Step',
                'description_ar' => 'Complete your first lesson on the platform',
                'description_en' => 'Complete your first lesson on the platform',
                'icon' => '🎓',
                'badge_color' => '#10b981',
                'type' => 'lesson',
                'criteria' => ['count' => 1],
                'points' => 10,
                'order' => 1,
            ],
            [
                'code' => 'first_track',
                'name_ar' => 'First Track',
                'name_en' => 'First Track',
                'description_ar' => 'Complete your first training track',
                'description_en' => 'Complete your first training track',
                'icon' => '🏁',
                'badge_color' => '#3b82f6',
                'type' => 'track',
                'criteria' => ['count' => 1],
                'points' => 50,
                'order' => 2,
            ],
            [
                'code' => 'perfect_quiz',
                'name_ar' => 'Perfect Quiz',
                'name_en' => 'Perfect Quiz',
                'description_ar' => 'Score 100% on a quiz',
                'description_en' => 'Score 100% on a quiz',
                'icon' => '💯',
                'badge_color' => '#f59e0b',
                'type' => 'quiz',
                'criteria' => ['score' => 100],
                'points' => 30,
                'order' => 3,
            ],
            [
                'code' => 'five_tracks',
                'name_ar' => 'Advanced Learner',
                'name_en' => 'Advanced Learner',
                'description_ar' => 'Complete 5 training tracks',
                'description_en' => 'Complete 5 training tracks',
                'icon' => '⭐',
                'badge_color' => '#8b5cf6',
                'type' => 'track',
                'criteria' => ['count' => 5],
                'points' => 100,
                'order' => 4,
            ],
            [
                'code' => 'active_learner',
                'name_ar' => 'Active Learner',
                'name_en' => 'Active Learner',
                'description_ar' => 'Learn for 7 consecutive days',
                'description_en' => 'Learn for 7 consecutive days',
                'icon' => '🔥',
                'badge_color' => '#ef4444',
                'type' => 'streak',
                'criteria' => ['days' => 7],
                'points' => 75,
                'order' => 5,
            ],
            [
                'code' => 'expert',
                'name_ar' => 'Expert',
                'name_en' => 'Expert',
                'description_ar' => 'Complete all training tracks',
                'description_en' => 'Complete all training tracks',
                'icon' => '👑',
                'badge_color' => '#fbbf24',
                'type' => 'track',
                'criteria' => ['all' => true],
                'points' => 200,
                'order' => 6,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['code' => $achievement['code']],
                $achievement
            );
        }

        $this->command->info('Achievements seeded successfully!');
    }
}

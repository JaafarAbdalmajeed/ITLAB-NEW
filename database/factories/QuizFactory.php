<?php

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition()
    {
        return [
            'track_id' => Track::factory(), // سيتم تحديده عند الإنشاء في Seeder
            'title' => $this->faker->words(3, true) . ' Quiz',
        ];
    }
}

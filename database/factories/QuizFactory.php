<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizFactory extends Factory
{
    protected $model = Quiz::class;

   public function definition()
{
    return [
        'track_id' => null, // سيتم تحديده عند الإنشاء في Seeder
        'question' => $this->faker->sentence(3),
        'option_a' => $this->faker->word(),
        'option_b' => $this->faker->word(),
        'option_c' => $this->faker->word(),
        'correct_answer' => $this->faker->word(),
    ];
}
}

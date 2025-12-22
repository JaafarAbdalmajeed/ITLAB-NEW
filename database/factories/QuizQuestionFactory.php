<?php

namespace Database\Factories;

use App\Models\QuizQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuizQuestionFactory extends Factory
{
    protected $model = QuizQuestion::class;

    public function definition()
    {
        $options = [
            'a' => $this->faker->sentence(),
            'b' => $this->faker->sentence(),
            'c' => $this->faker->sentence(),
        ];

        return [
            'quiz_id' => null, // set when creating
            'question' => $this->faker->sentence() . '?',
            'option_a' => $options['a'],
            'option_b' => $options['b'],
            'option_c' => $options['c'],
            'correct_answer' => $this->faker->randomElement(['a', 'b', 'c']),
        ];
    }
}

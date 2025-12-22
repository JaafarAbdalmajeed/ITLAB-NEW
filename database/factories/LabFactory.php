<?php

namespace Database\Factories;

use App\Models\Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabFactory extends Factory
{
    protected $model = Lab::class;

    public function definition()
    {
        return [
            'track_id' => null, // set when creating
            'title' => $this->faker->sentence(3),
            'scenario' => $this->faker->paragraphs(2, true),
        ];
    }
}

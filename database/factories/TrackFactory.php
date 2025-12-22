<?php

namespace Database\Factories;

use App\Models\Track;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TrackFactory extends Factory
{
    protected $model = Track::class;

    public function definition()
    {
        $title = $this->faker->unique()->words(3, true);

        return [
            'slug' => Str::slug($title),
            'title' => ucfirst($title),
            'description' => $this->faker->paragraph(),
        ];
    }
}

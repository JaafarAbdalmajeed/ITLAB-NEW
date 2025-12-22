<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'subject' => $this->faker->optional()->sentence(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'message' => $this->faker->paragraphs(3, true),
            'read' => $this->faker->boolean(30), // 30% chance of being read
            'read_at' => function (array $attributes) {
                return $attributes['read'] ? $this->faker->dateTimeBetween('-1 month', 'now') : null;
            },
            'read_by' => null,
            'admin_notes' => $this->faker->optional(0.2)->paragraph(), // 20% chance of having notes
        ];
    }

    /**
     * Indicate that the contact message is unread.
     */
    public function unread(): static
    {
        return $this->state(fn (array $attributes) => [
            'read' => false,
            'read_at' => null,
            'read_by' => null,
        ]);
    }

    /**
     * Indicate that the contact message is read.
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read' => true,
            'read_at' => now(),
        ]);
    }
}


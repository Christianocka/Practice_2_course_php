<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->optional()->paragraph,
            'is_done' => false,
            'priority' => 1,
            'tags' => [],
            'start_at' => null,
            'end_at' => null,
            'parent_id' => null,
        ];
    }
}


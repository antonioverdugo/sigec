<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn(array $attributes) => ['name' => 'admin']);
    }

    public function ponente(): static
    {
        return $this->state(fn(array $attributes) => ['name' => 'ponente']);
    }

    public function asistente(): static
    {
        return $this->state(fn(array $attributes) => ['name' => 'asistente']);
    }
}
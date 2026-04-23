<?php

namespace Database\Factories;

use App\Models\TypeSponsor;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeSponsorFactory extends Factory
{
    protected $model = TypeSponsor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }

    public function bronze(): static
    {
        return $this->state(fn(array $attributes) => ['name' => 'bronze']);
    }

    public function silver(): static
    {
        return $this->state(fn(array $attributes) => ['name' => 'silver']);
    }

    public function gold(): static
    {
        return $this->state(fn(array $attributes) => ['name' => 'gold']);
    }

    public function platinum(): static
    {
        return $this->state(fn(array $attributes) => ['name' => 'platinum']);
    }
}
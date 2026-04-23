<?php

namespace Database\Factories;

use App\Models\TypePresentation;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypePresentationFactory extends Factory
{
    protected $model = TypePresentation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
        ];
    }

    public function poster(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'poster',
            'description' => 'Tipo de presentación póster',
        ]);
    }

    public function oral(): static
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'oral',
            'description' => 'Tipo de presentación oral',
        ]);
    }
}
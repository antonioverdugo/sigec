<?php

namespace Database\Factories;

use App\Models\Sponsor;
use App\Models\TypeSponsor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SponsorFactory extends Factory
{
    protected $model = Sponsor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'email' => $this->faker->companyEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'amount_contributed' => $this->faker->randomFloat(2, 1000, 100000),
            'type_sponsor_id' => TypeSponsor::factory(),
        ];
    }

    public function gold(): static
    {
        return $this->state(fn(array $attributes) => [
            'type_sponsor_id' => TypeSponsor::factory()->gold(),
        ]);
    }

    public function platinum(): static
    {
        return $this->state(fn(array $attributes) => [
            'type_sponsor_id' => TypeSponsor::factory()->platinum(),
        ]);
    }
}
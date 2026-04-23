<?php

namespace Database\Factories;

use App\Models\Poster;
use App\Models\User;
use App\Models\Category;
use App\Models\TypePresentation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PosterFactory extends Factory
{
    protected $model = Poster::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'summary' => $this->faker->paragraph(3),
            'url_file' => 'posters/' . $this->faker->uuid() . '.pdf',
            'type_presentation_id' => TypePresentation::factory()->poster(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'published' => $this->faker->boolean(70),
        ];
    }

    public function published(): static
    {
        return $this->state(fn(array $attributes) => ['published' => true]);
    }

    public function unpublished(): static
    {
        return $this->state(fn(array $attributes) => ['published' => false]);
    }
}
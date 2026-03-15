<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Crear categorías
    $categories = [
      [
        'name' => 'General',
        'description' =>
          'Esta categoria es la preestablecida si no se proporciona una categoria',
      ],
      [
        'name' => 'Ciberseguridad',
        'description' =>
          'En esta categoria se incluiran ponencias relacionadas con ciberseguridad',
      ],
      [
        'name' => 'Cloud Computing',
        'description' =>
          'En esta categoria se incluiran ponencias relacionadas con cloud computing',
      ],
      [
        'name' => 'Administracion de Sistemas',
        'description' =>
          'En esta categoria se incluiran ponencias relacionadas con administracion de sistemas',
      ],
    ];

    foreach ($categories as $category) {
      Category::create($category);
    }
  }
}

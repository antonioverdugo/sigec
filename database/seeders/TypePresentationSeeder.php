<?php

namespace Database\Seeders;

use App\Models\TypePresentation;
use Illuminate\Database\Seeder;

class TypePresentationSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $typesPresentations = [
      [
        'name' => 'oral',
        'description' =>
          'Este tipo de ponencia se presenta en powerpoint, keynotes o pdf de forma presencial',
      ],
      [
        'name' => 'poster',
        'description' =>
          'Este tipo de ponencia se presenta en formato pdf o imagen de una solo página',
      ],
    ];

    foreach ($typesPresentations as $typePresentation) {
      TypePresentation::create($typePresentation);
    }
  }
}

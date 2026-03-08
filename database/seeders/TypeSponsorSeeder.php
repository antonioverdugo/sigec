<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeSponsor;

class TypeSponsorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $typesSponsors = [
      ['id' => 1, 'name' => 'oro'],
      ['id' => 2, 'name' => 'plata'],
      ['id' => 3, 'name' => 'bronce'],
      ['id' => 4, 'name' => 'colaborador'],
      ['id' => 5, 'name' => 'institucional'],
    ];
    foreach ($typesSponsors as $typesponsor) {
      TypeSponsor::create($typesponsor);
  }
}
}
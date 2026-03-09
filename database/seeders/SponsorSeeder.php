<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sponsor;

class SponsorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // protected $fillable = [
    //   'name',
    //   'email',
    //   'phone',
    //   'amount_contributed',
    //   'type_sponsor_id',
    // ];
    //Crear varios sponsors de distinto tipo

    $sponsors = [
      [
        'name' => 'IBM Corporation',
        'email' => 'manuel@ibm.com',
        'phone' => '675282828',
        'amount_contributed' => 5000,
        'type_sponsor_id' => 1,
      ],
      [
        'name' => 'Microsoft Corporation',
        'email' => 'bernardo@microsoft.com',
        'phone' => '678545432',
        'amount_contributed' => 2000,
        'type_sponsor_id' => 2,
      ],
      [
        'name' => 'Oracle Foundation',
        'email' => 'pepe@oraclefoundation.com',
        'phone' => '654987609',
        'amount_contributed' => 1500,
        'type_sponsor_id' => 3,
      ],
      [
        'name' => 'Linux Foundation',
        'email' => 'antonio@linuxfoundation.org',
        'phone' => '675432109',
        'amount_contributed' => 500,
        'type_sponsor_id' => 4,
      ],
      [
        'name' => 'Junta de Andalucia',
        'email' => 'lucia@juntaandalucia.es',
        'phone' => '657895634',
        'amount_contributed' => 10000,
        'type_sponsor_id' => 5,
      ],
    ];

    // Recorrer los sponsors
    foreach ($sponsors as $sponsor) {
      Sponsor::create($sponsor);
    }
  }
}

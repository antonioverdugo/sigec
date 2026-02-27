<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    //protected $fillable = ['name', 'email', 'password', 'role_id'];
    // Añadir varios usuarios con distintos roles
    $users = [
      [
        'name' => 'Manuel Rodríguez Escudero',
        'email' => 'manuel@iesaguadulce.es',
        'password' => '123456',
        'role_id' => 3,
      ],
      [
        'name' => 'Antonio Ramón Verdugo Garcia',
        'email' => 'antonio@prueba.es',
        'password' => '123456',
        'role_id' => 3,
      ],
      [
        'name' => 'Lucia Rodriguez Aguado',
        'email' => 'lucia@tech.es',
        'password' => '123456',
        'role_id' => 2,
      ],
      [
        'name' => 'Leo Verdugo Rodriguez',
        'email' => 'leo@innova.es',
        'password' => '123456',
        'role_id' => 2,
      ],
      [
        'name' => 'Victor Menacho Borrego',
        'email' => 'vito@rancho.es',
        'password' => '123456',
        'role_id' => 1,
      ],
    ];

    // Recorrer los usuarios
    foreach ($users as $user) {
      User::create($user);
    }
  }
}

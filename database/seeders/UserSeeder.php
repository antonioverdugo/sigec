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
        'password' => '12345678',
        'role_id' => 3,
      ],
      [
        'name' => 'Antonio Ramón Verdugo Garcia',
        'email' => 'antonio@prueba.es',
        'password' => '12345678',
        'role_id' => 3,
      ],
      [
        'name' => 'Lucia Rodriguez Aguado',
        'email' => 'lucia@tech.es',
        'password' => '12345678',
        'role_id' => 2,
      ],
      [
        'name' => 'Leo Verdugo Rodriguez',
        'email' => 'leo@innova.es',
        'password' => '12345678',
        'role_id' => 2,
      ],
      [
        'name' => 'Victor Menacho Borrego',
        'email' => 'vito@rancho.es',
        'password' => '12345678',
        'role_id' => 1,
      ],
      [
        'name' => 'Chicarron Becerra Puertas',
        'email' => 'chicarro@alcala.es',
        'password' => '12345678',
        'role_id' => 2,
      ],
      [
        'name' => 'Ana Diaz Herrera',
        'email' => 'ana@alcala.es',
        'password' => '12345678',
        'role_id' => 1,
      ],
      [
        'name' => 'Monica',
        'email' => 'monica@ambigu.es',
        'password' => '12345678',
        'role_id' => 2,
      ],
      [
        'name' => 'Jesus Carrasco Raya',
        'email' => 'jesus@jecara.es',
        'password' => '12345678',
        'role_id' => 1,
      ],
      [
        'name' => 'Paco Parrilla Fuentes',
        'email' => 'pado@inmo.es',
        'password' => '12345678',
        'role_id' => 3,
      ],
      [
        'name' => 'Maria Jose Cedeño Garcia',
        'email' => 'mjose@salesianos.es',
        'password' => '12345678',
        'role_id' => 2,
      ],
      [
        'name' => 'Juan Antonio Perez Martin',
        'email' => 'jantonio@andalucia.es',
        'password' => '12345678',
        'role_id' => 1,
      ],
      [
        'name' => 'Charo Becerra Puertas',
        'email' => 'charo@fabrica.es',
        'password' => '12345678',
        'role_id' => 3,
      ],
      [
        'name' => 'Ana Mari Valverde Ruiz',
        'email' => 'amari@tienda.es',
        'password' => '12345678',
        'role_id' => 1,
      ],
    ];

    // Recorrer los usuarios
    foreach ($users as $user) {
      User::create($user);
    }
  }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    //Añadir la columna de role como foreign de role
    Schema::table('users', function (Blueprint $table): void {
      $table
        ->foreignId('role_id')
        ->default(1)
        ->constrained('roles')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Acciones para el rollback
    Schema::table('users', function (Blueprint $table): void {
      $table->dropForeign(['role_id']);
      $table->dropColumn('role_id');
    });
  }
};

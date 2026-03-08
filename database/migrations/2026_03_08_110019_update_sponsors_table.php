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
    Schema::table('sponsors', function (Blueprint $table): void {
      $table
        ->foreignId('type_sponsor_id')
        ->constrained('types_sponsors')
        ->onDelete('cascade')
        ->onUpdate('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    // Acciones para el rollback
    Schema::table('sponsors', function (Blueprint $table): void {
      $table->dropForeign(['type_sponsor_id']);
      $table->dropColumn('type_sponsor_id');
    });
  }
};

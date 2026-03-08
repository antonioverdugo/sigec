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
    Schema::create('sponsors', function (Blueprint $table) {
      $table->id();
      $table->string('name', 255);
      $table->string('email', 255);
      $table->string('phone', 13)->nullable();
      $table->float('amount_contributed', 15, 2)->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('sponsors');
  }
};

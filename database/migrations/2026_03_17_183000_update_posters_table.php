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
        // Añadir las columnas de las foreign keys
        Schema::table("posters", function (Blueprint $table): void {
            $table
                ->foreignId("type_presentation_id")
                ->constrained("type_presentations")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table
                ->foreignId("user_id")
                ->constrained("users")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table
                ->foreignId("category_id")
                ->constrained("categories")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("posters", function (Blueprint $table): void {
            // Eliminamos los foreign key
            $table->dropForeign(["type_presentation_id"]);
            $table->dropForeign(["user_id"]);
            $table->dropForeign(["category_id"]);

            // Eliminamos las columnas
            $table->dropColumn(["type_presentation_id"]);
            $table->dropColumn(["user_id"]);
            $table->dropColumn(["category_id"]);
        });
    }
};

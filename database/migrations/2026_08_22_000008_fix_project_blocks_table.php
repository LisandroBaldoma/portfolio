<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop la tabla anterior si existe
        if (Schema::hasTable('project_blocks')) {
            Schema::dropIfExists('project_blocks');
        }

        // Recrear con tipos correctos
        Schema::create('project_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();
            $table->enum('type', ['title', 'text', 'image']);
            $table->longText('data'); // JSON serializado
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('project_id');
            $table->index('sort_order');
            $table->unique(['project_id', 'type']); // Un bloque por tipo por proyecto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_blocks');
    }
};

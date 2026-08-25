<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('company')->nullable();
            $table->string('inquiry_type');
            $table->text('message');
            $table->string('status')->default('nuevo');
            $table->timestamps();
        });

        Schema::create('contact_service', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['contact_id', 'service_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_service');
        Schema::dropIfExists('contacts');
    }
};

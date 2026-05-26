<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('breed')->nullable();
            $table->decimal('age_years', 4, 1)->nullable();
            $table->integer('birth_year')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('personality')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('size', 16)->nullable();
            $table->string('gender', 16)->default('unspecified');
            $table->text('health_notes')->nullable();
            $table->boolean('vaccinated')->default(false);
            $table->json('photos')->nullable();
            $table->boolean('neutered')->nullable();
            $table->boolean('microchipped')->nullable();
            $table->json('vaccinations')->nullable();
            $table->string('vet')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dogs');
    }
};

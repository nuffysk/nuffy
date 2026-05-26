<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sos_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->string('city')->nullable();
            $table->text('description');
            $table->string('photo_url')->nullable();
            $table->string('contact')->nullable();
            $table->string('status', 16)->default('open');
            $table->string('kind', 16)->default('found');
            $table->timestamps();
            $table->index(['kind', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sos_reports');
    }
};

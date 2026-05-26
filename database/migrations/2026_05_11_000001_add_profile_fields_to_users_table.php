<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('name');
            $table->string('city')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('gender', 16)->default('unspecified');
            $table->json('with_dog_photos')->nullable();
            $table->text('bio')->nullable();
            $table->integer('birth_year')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'city', 'avatar_url', 'gender', 'with_dog_photos', 'bio', 'birth_year']);
        });
    }
};

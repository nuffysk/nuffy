<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Novinky — admin-authored news/updates
        Schema::create('novinky', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->unique();
            $table->string('title', 200);
            $table->longText('content');
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->index('created_at');
        });

        // Forum comment / topic reports — user-submitted moderation flags
        Schema::create('forum_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->string('target_type', 16); // topic | comment
            $table->unsignedBigInteger('target_id');
            $table->string('reason', 60);
            $table->string('status', 16)->default('open'); // open | reviewed | dismissed
            $table->timestamps();
            $table->index(['target_type', 'target_id']);
            $table->unique(['reporter_id', 'target_type', 'target_id']);
        });

        // Instagram handle on profile + SOS reports
        Schema::table('users', function (Blueprint $table) {
            $table->string('instagram', 60)->nullable()->after('avatar_url');
        });
        Schema::table('sos_reports', function (Blueprint $table) {
            $table->string('phone', 40)->nullable()->after('contact');
            $table->string('instagram', 60)->nullable()->after('phone');
        });

        // walk_invites: dropped in the React repo (feature replaced by forum)
        Schema::dropIfExists('walk_invites');
    }

    public function down(): void
    {
        Schema::create('walk_invites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('place_id')->nullable()->constrained('places')->nullOnDelete();
            $table->timestamp('scheduled_at');
            $table->text('message')->nullable();
            $table->string('status', 16)->default('pending');
            $table->timestamps();
        });

        Schema::table('sos_reports', function (Blueprint $table) {
            $table->dropColumn(['phone', 'instagram']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('instagram');
        });
        Schema::dropIfExists('forum_reports');
        Schema::dropIfExists('novinky');
    }
};

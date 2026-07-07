<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Grandfather existing accounts as verified so introducing the `verified`
     * middleware does not lock out users who registered before e-mail
     * verification was enforced.
     */
    public function up(): void
    {
        DB::table('users')
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => now()]);
    }

    public function down(): void
    {
        // No-op: we cannot know which users were previously unverified.
    }
};

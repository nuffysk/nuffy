<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Content screens are newly gated behind the `platform.content` permission.
     * Grant it to every role and user that already has admin access
     * (`platform.index`), so existing admins keep managing content seamlessly.
     */
    public function up(): void
    {
        foreach (['roles', 'users'] as $table) {
            DB::table($table)
                ->whereNotNull('permissions')
                ->orderBy('id')
                ->chunkById(100, function ($rows) use ($table) {
                    foreach ($rows as $row) {
                        $permissions = json_decode($row->permissions ?? '[]', true) ?: [];

                        if (! empty($permissions['platform.index'])) {
                            $permissions['platform.content'] = true;

                            DB::table($table)
                                ->where('id', $row->id)
                                ->update(['permissions' => json_encode($permissions)]);
                        }
                    }
                });
        }
    }

    public function down(): void
    {
        // Leave the permission in place — harmless if unused.
    }
};

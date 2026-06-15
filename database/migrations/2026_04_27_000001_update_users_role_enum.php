<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * Expand the role enum to include 'employee' and 'client' roles.
     */
    public function up(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            // MySQL requires modifying column with new enum values
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'client', 'employee') NOT NULL DEFAULT 'client'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'client', 'employee') NOT NULL DEFAULT 'client'");
        }
    }
};

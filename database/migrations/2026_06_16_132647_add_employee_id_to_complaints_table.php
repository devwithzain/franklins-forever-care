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
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('employee_id')->nullable()->constrained('users')->nullOnDelete()->after('client_id');
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['employee_id']);
            $table->dropForeign(['resolved_by']);
            $table->dropColumn(['employee_id', 'resolved_by']);
        });
    }
};
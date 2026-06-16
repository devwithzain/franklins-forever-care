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
        Schema::table('outdoor_activities', function (Blueprint $table) {
            $table->string('activity_type')->after('activity_name')->nullable();
            $table->text('notes')->after('location')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outdoor_activities', function (Blueprint $table) {
            $table->dropColumn(['activity_type', 'notes']);
        });
    }
};

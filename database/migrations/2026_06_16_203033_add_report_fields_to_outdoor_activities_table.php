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
            $table->text('report_summary')->nullable();
            $table->string('report_participation_level')->nullable();
            $table->text('report_outcome_notes')->nullable();
            $table->text('report_follow_up_recommendations')->nullable();
            $table->integer('duration_minutes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outdoor_activities', function (Blueprint $table) {
            $table->dropColumn([
                'report_summary',
                'report_participation_level',
                'report_outcome_notes',
                'report_follow_up_recommendations',
                'duration_minutes'
            ]);
        });
    }
};

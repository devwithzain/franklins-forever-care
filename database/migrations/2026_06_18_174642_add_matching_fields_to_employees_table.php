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
        Schema::table('employees', function (Blueprint $table) {
            $table->text('skills')->nullable();
            $table->text('certifications')->nullable();
            $table->text('languages')->nullable();
            $table->text('service_areas')->nullable();
            $table->string('availability')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'skills',
                'certifications',
                'languages',
                'service_areas',
                'availability',
            ]);
        });
    }
};

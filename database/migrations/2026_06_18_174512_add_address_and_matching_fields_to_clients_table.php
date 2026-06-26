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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();

            $table->string('care_needs')->nullable();
            $table->string('mobility_level')->nullable();
            $table->string('preferred_language')->nullable();
            $table->text('special_requirements')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'city',
                'state',
                'zip_code',
                'latitude',
                'longitude',
                'emergency_contact_name',
                'emergency_contact_phone',
                'emergency_contact_relationship',
                'care_needs',
                'mobility_level',
                'preferred_language',
                'special_requirements',
            ]);
        });
    }
};

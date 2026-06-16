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
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('service_booking_id')->nullable()->after('employee_id');
            $table->unsignedBigInteger('client_id')->nullable()->after('service_booking_id');
            $table->decimal('check_in_latitude', 10, 7)->nullable();
            $table->decimal('check_in_longitude', 10, 7)->nullable();
            $table->decimal('check_out_latitude', 10, 7)->nullable();
            $table->decimal('check_out_longitude', 10, 7)->nullable();

            // Allow missed punches to be marked as pending review
            $table->string('status')->default('Present')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'service_booking_id',
                'client_id',
                'check_in_latitude',
                'check_in_longitude',
                'check_out_latitude',
                'check_out_longitude'
            ]);
        });
    }
};

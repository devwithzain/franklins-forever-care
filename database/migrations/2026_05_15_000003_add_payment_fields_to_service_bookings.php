<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->string('payment_status')->default('unpaid')->after('status');
            $table->string('stripe_session_id')->nullable()->after('payment_status');
            $table->decimal('amount', 10, 2)->nullable()->after('stripe_session_id');
        });
    }

    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'stripe_session_id', 'amount']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->string('stripe_customer_id')->nullable()->after('stripe_session_id');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_customer_id');
            $table->string('subscription_status')->default('inactive')->after('stripe_subscription_id');
            // subscription_status values: inactive | active | cancelled | past_due
            $table->timestamp('subscription_ends_at')->nullable()->after('subscription_status');
        });
    }

    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_customer_id', 
                'stripe_subscription_id',
                'subscription_status', 
                'subscription_ends_at',
            ]);
        });
    }
};

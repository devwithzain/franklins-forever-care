<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('plan_type'); 
            $table->string('patient_name');
            $table->string('patient_age');
            $table->string('relationship'); 
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->date('preferred_date')->nullable();
            $table->date('booking_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending');
              $table->string('payment_status')->default('unpaid')->after('status');
            $table->string('stripe_session_id')->nullable()->after('payment_status');
            $table->decimal('amount', 10, 2)->nullable()->after('stripe_session_id');
            $table->string('stripe_customer_id')->nullable()->after('stripe_session_id');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_customer_id');
            $table->string('subscription_status')->default('inactive')->after('stripe_subscription_id');
            $table->timestamp('subscription_ends_at')->nullable()->after('subscription_status');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_bookings');
    }
};
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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // unassigned_booking, request_pending, payment_overdue, etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional context (booking_id, client_name, etc.)
            $table->boolean('is_read')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade'); // Target admin/user
            $table->timestamps();
            
            $table->index(['is_read', 'created_at']);
            $table->index(['type', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};

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
        Schema::create('employee_workloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Employee
            $table->date('date');
            $table->integer('active_bookings')->default(0);
            $table->integer('max_capacity')->default(5); // Max bookings per day
            $table->decimal('workload_score', 5, 2)->default(0); // Calculated score
            $table->timestamps();
            
            $table->unique(['user_id', 'date']);
            $table->index(['date', 'workload_score']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_workloads');
    }
};

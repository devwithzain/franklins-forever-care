<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('client_custom_id')->unique();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('region')->nullable();
            $table->string('care_plan')->nullable();
            $table->foreignId('agent_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};

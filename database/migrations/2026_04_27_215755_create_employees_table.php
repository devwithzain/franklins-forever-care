<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('agent_custom_id')->unique();
            $table->string('phone')->nullable();
            $table->string('ssn')->nullable();
            $table->string('region')->nullable();
            $table->string('type')->default('Full-time');
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

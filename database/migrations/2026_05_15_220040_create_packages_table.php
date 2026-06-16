<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('price');
            $table->json('features');
            $table->string('duration');
            $table->boolean('popular')->default(false);
            $table->decimal('amount', 8, 2)->default(0);
            $table->string('color')->default('#DDEEE7');
            $table->string('text_color')->default('#2E6A51');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->foreignId('service_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
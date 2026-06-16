<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('career_applications', function (Blueprint $row) {
            $row->id();
             $row->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $row->string('full_name');
            $row->string('email');
            $row->string('phone');
            $row->string('address');
            $row->string('city');
            $row->string('state');
            $row->string('zip_code');
            $row->text('message')->nullable();
            $row->string('status')->default('pending'); 
            $row->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};
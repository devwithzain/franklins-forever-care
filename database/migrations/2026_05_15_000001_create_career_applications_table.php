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
        Schema::create('career_applications', function (Blueprint $row) {
            $row->id();
            $row->string('full_name');
            $row->string('email');
            $row->string('phone');
            $row->string('address');
            $row->string('city');
            $row->string('state');
            $row->string('zip_code');
            $row->text('message')->nullable();
            $row->string('status')->default('pending'); // pending, reviewed, accepted, rejected
            $row->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_applications');
    }
};

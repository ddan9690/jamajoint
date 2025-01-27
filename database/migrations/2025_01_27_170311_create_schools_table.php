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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('level');
            $table->string('type');
            $table->foreignId('county_id')->nullable(); // Changed to foreignId for county relationship
            $table->string('slug')->unique();
            $table->enum('status', [0, 1])->default(0);
            $table->timestamps();

            $table->foreign('county_id')->references('id')->on('counties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
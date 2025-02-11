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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('form_id');
            $table->string('term');
            $table->year('year');
            $table->unsignedBigInteger('grading_system_id');
            $table->string('slug')->unique();
            $table->enum('published', ['yes', 'no'])->default('no');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('grading_system_id')->references('id')->on('grading_systems')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};

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
        Schema::create('gradings', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('grading_system_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('grading_system_id');
            $table->string('grade');
            $table->decimal('low', 5, 2);
            $table->decimal('high', 5, 2);
            $table->integer('points');
            $table->timestamps();

            $table->foreign('grading_system_id')->references('id')->on('grading_systems')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('gradings');
    }
};

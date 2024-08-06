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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Add title field
            $table->string('slug')->unique(); // Add slug field with a unique constraint
            $table->text('description'); // Add description field
            $table->unsignedBigInteger('user_id'); // Add user_id field to associate with a user
            $table->enum('published', ['yes', 'no'])->default('no'); // Add published field with enum
            $table->enum('featured', [0, 1])->default(0); // Add featured field with enum
            $table->timestamps();

            // Define foreign key constraint for user_id
            // $table->foreign('user_id')->references('id')->on('users'); // Assuming you have a 'users' table
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

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
        Schema::create('cyber_papers', function (Blueprint $table) {
            $table->id();
            $table->string('name');  // Add the 'name' column as a string
            $table->string('paper'); // Add the 'paper' column as a string
            $table->string('term');  // Add the 'term' column as a string
            $table->year('year');    // Add the 'year' column as a year
            $table->unsignedBigInteger('user_id'); // Add the 'user_id' column as an unsigned big integer

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cyber_papers');
    }
};

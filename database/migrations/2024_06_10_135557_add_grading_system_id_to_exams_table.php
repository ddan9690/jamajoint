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
        Schema::table('exams', function (Blueprint $table) {
            $table->unsignedBigInteger('grading_system_id')->after('year');
            $table->foreign('grading_system_id')->references('id')->on('grading_systems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['grading_system_id']);
            $table->dropColumn('grading_system_id');
        });
    }
};

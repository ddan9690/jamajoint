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
        Schema::table('cyber_papers', function (Blueprint $table) {
            $table->dropColumn('paper');
            $table->dropColumn('term');
            $table->dropColumn('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cyber_papers', function (Blueprint $table) {
            $table->string('paper');
            $table->string('term');
            $table->year('year');
        });
    }
};

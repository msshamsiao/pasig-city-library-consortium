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
        // Add acronym to libraries table
        Schema::table('libraries', function (Blueprint $table) {
            $table->string('acronym', 20)->nullable()->after('name');
        });

        // Add holding_branch_id to holdings table
        Schema::table('holdings', function (Blueprint $table) {
            $table->foreignId('holding_branch_id')->nullable()->after('id')->constrained('libraries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove holding_branch_id from holdings table
        Schema::table('holdings', function (Blueprint $table) {
            $table->dropForeign(['holding_branch_id']);
            $table->dropColumn('holding_branch_id');
        });

        // Remove acronym from libraries table
        Schema::table('libraries', function (Blueprint $table) {
            $table->dropColumn('acronym');
        });
    }
};

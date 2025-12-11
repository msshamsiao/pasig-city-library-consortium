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
        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('library_id')->nullable()->after('id')->constrained('libraries')->nullOnDelete();
            $table->string('approval_status')->default('pending')->after('is_published'); // pending, approved, rejected
            $table->text('rejection_reason')->nullable()->after('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['library_id']);
            $table->dropColumn(['library_id', 'approval_status', 'rejection_reason']);
        });
    }
};

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
        // Drop book_requests table
        Schema::dropIfExists('book_requests');

        // Update borrowings table to use member_id instead of user_id
        Schema::table('borrowings', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Rename user_id to member_id
            $table->renameColumn('user_id', 'member_id');
        });

        // Add foreign key constraint to members table
        Schema::table('borrowings', function (Blueprint $table) {
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate book_requests table
        Schema::create('book_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('material_type');
            $table->date('date_schedule');
            $table->string('date_time');
            $table->string('status')->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // Revert borrowings table to use user_id
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropForeign(['member_id']);
            $table->renameColumn('member_id', 'user_id');
        });

        Schema::table('borrowings', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};

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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('user_name')->nullable(); // Store name in case user is deleted
            $table->string('user_role')->nullable(); // admin, member_librarian, borrower
            $table->foreignId('library_id')->nullable()->constrained('libraries')->onDelete('set null');
            $table->string('action'); // create, update, delete, approve, reject, borrow, return, cancel, login, logout
            $table->string('model'); // Book, User, Library, Borrowing, Activity, etc.
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the affected record
            $table->text('description'); // Human-readable description
            $table->json('old_values')->nullable(); // Before changes
            $table->json('new_values')->nullable(); // After changes
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['library_id', 'created_at']);
            $table->index(['action', 'created_at']);
            $table->index(['model', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};

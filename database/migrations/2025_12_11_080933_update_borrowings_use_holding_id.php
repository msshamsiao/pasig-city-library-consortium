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
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
            $table->renameColumn('book_id', 'holding_id');
            $table->foreign('holding_id')->references('id')->on('holdings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            $table->dropForeign(['holding_id']);
            $table->renameColumn('holding_id', 'book_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }
};

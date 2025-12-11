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
            $table->time('time_start')->nullable()->after('activity_date');
            $table->time('time_end')->nullable()->after('time_start');
            $table->string('location')->nullable()->after('description');
            $table->integer('max_participants')->nullable()->after('location');
            $table->integer('current_participants')->default(0)->after('max_participants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn(['time_start', 'time_end', 'location', 'max_participants', 'current_participants']);
        });
    }
};

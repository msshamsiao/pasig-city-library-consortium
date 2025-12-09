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
        Schema::table('users', function (Blueprint $table) {
            $table->string('member_id')->unique()->nullable()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->string('member_type')->default('regular')->after('phone'); // regular, student, senior, faculty
            $table->string('status')->default('active')->after('member_type'); // active, inactive, suspended
            $table->integer('books_borrowed')->default(0)->after('status');
            $table->decimal('total_fines', 10, 2)->default(0)->after('books_borrowed');
            $table->date('membership_date')->nullable()->after('total_fines');
            $table->date('last_login_date')->nullable()->after('membership_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'member_id',
                'phone',
                'member_type',
                'status',
                'books_borrowed',
                'total_fines',
                'membership_date',
                'last_login_date'
            ]);
        });
    }
};

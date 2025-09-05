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
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('workplace')->nullable();
            $table->string('position')->nullable();
            $table->string('academic_degree')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_verified_manually')->default(false);
            $table->timestamp('membership_paid_until')->nullable();
            $table->enum('membership_type', ['individual', 'organization'])->default('individual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'city', 'workplace', 'position', 'academic_degree',
                'is_admin', 'is_verified_manually', 'membership_paid_until', 'membership_type'
            ]);
        });
    }
};

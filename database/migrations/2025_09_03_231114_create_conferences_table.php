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
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('registration_opens_at');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->string('location');
            $table->string('conference_type');
            $table->longText('announcement')->nullable();
            $table->json('important_dates')->nullable();
            $table->json('events')->nullable(); // дата-формат участия-тип участника
            $table->longText('description')->nullable();
            $table->longText('post_release')->nullable();
            $table->json('materials')->nullable(); // файлы
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conferences');
    }
};

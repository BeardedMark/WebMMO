<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('creator_id')->constrained('characters')->cascadeOnDelete();
            $table->foreignId('opponent_id')->nullable()->constrained('characters')->cascadeOnDelete();
            $table->foreignId('winner_id')->nullable()->constrained('characters')->cascadeOnDelete();

            $table->enum('type', ['normal', 'rating', 'brutal', 'siege'])->default('normal');
            $table->string('commentary')->nullable();
            $table->json('logs')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('battles');
    }
};

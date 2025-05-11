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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('name');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('experience')->default(0);

            $table->timestamp('regenerated_at')->default(now());
            $table->timestamp('next_action_at')->default(now()->addSeconds(10));
            $table->json('items')->nullable();
            $table->json('logs')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};

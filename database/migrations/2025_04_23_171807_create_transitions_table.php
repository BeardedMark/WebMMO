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
        Schema::create('transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('to_location_id')->constrained('locations')->onDelete('cascade');

            $table->timestamp('next_action_at');
            $table->json('items')->nullable();
            $table->json('npc')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transitions');
    }
};

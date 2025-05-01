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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('Название');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->text('comment')->nullable();
            $table->string('tags')->nullable();
            $table->json('data')->nullable();
            $table->string('image')->nullable();
            $table->string('sound')->nullable();

            $table->decimal('weight', 8, 2)->default(0);
            $table->unsignedTinyInteger('max_stack')->default(1);
            $table->unsignedTinyInteger('drop_chance')->default(0);
            $table->unsignedTinyInteger('min_level')->nullable();
            $table->unsignedTinyInteger('max_level')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

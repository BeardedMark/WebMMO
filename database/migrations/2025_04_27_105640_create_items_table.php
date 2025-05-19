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

            $table->string('class')->nullable();
            $table->decimal('weight', 8, 2)->default(0);
            $table->integer('max_stack')->default(1);
            $table->integer('max_modifiers')->default(0);
            $table->integer('drop_chance')->default(0);
            $table->integer('min_level')->nullable();
            $table->integer('max_level')->nullable();
            $table->json('properties')->nullable();
            $table->json('modifiers')->nullable();
            $table->json('craft')->nullable();

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

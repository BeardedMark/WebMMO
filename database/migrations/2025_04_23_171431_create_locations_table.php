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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->text('comment')->nullable();
            $table->string('tags')->nullable();
            $table->json('data')->nullable();
            $table->string('image')->nullable();
            $table->string('sound')->nullable();

            $table->integer('level')->default(0);
            $table->integer('size')->default(1);
            $table->boolean('is_open')->default(true);
            $table->boolean('is_hideout')->default(true);
            $table->boolean('is_peaceful')->default(false);
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

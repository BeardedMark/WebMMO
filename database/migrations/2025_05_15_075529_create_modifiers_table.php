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
        Schema::create('modifiers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // например: physical_damage
            $table->string('name'); // отображаемое название: "Физический урон"
            $table->json('classes'); // ["weapon", "accessory"]
            $table->json('tags')->nullable();
            $table->integer('value')->default(1);             // базовое значение (например, 10)
            $table->integer('spread')->default(0); // разброс в процентах (например, ±20%)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modifiers');
    }
};

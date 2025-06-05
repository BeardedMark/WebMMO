<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Schema\MetaFieldsSchema;
use App\Schema\HasItemsSchema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();

            MetaFieldsSchema::applyContent($table);
            MetaFieldsSchema::applyMedia($table);

            $table->integer('level')->default(1);
            $table->integer('size')->nullable();
            $table->integer('x')->nullable();
            $table->integer('y')->nullable();

            $table->boolean('is_open')->default(true);
            $table->boolean('is_peaceful')->default(false);

            $table->json('modifiers')->nullable();
            $table->json('drop')->nullable();

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

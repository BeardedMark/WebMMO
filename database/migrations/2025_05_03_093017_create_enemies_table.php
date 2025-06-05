<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Schema\MetaFieldsSchema;
use App\Schema\HasModifiersSchema;
use App\Schema\HasItemsSchema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enemies', function (Blueprint $table) {
            $table->id();

            MetaFieldsSchema::applyMeta($table);
            MetaFieldsSchema::applyContent($table);
            MetaFieldsSchema::applyMedia($table);

            $table->integer('spawn_chance')->default(0);
            $table->integer('min_level')->nullable();
            $table->integer('max_level')->nullable();

            $table->json('drop')->nullable();
            $table->json('modifiers')->nullable();
            $table->json('requirements')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enemies');
    }
};

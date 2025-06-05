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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            MetaFieldsSchema::applyMeta($table);
            MetaFieldsSchema::applyContent($table);
            MetaFieldsSchema::applyMedia($table);

            $table->string('slot')->nullable();
            $table->decimal('weight', 8, 2)->default(0);
            $table->integer('drop_chance')->default(0);
            $table->integer('min_level')->default(1);
            $table->integer('max_level')->nullable();

            $table->boolean('is_assemble')->default(false);
            $table->boolean('is_disassemble')->default(false);

            $table->json('craft')->nullable();
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
        Schema::dropIfExists('items');
    }
};

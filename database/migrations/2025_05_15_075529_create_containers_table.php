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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();

            MetaFieldsSchema::applyMeta($table);
            MetaFieldsSchema::applyContent($table);
            MetaFieldsSchema::applyMedia($table);

            $table->string('class')->nullable();
            $table->float('spawn_chance')->default(100);
            $table->integer('min_level')->nullable();
            $table->integer('max_level')->nullable();

            $table->json('drop')->nullable();
            $table->json('requirements')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containers');
    }
};

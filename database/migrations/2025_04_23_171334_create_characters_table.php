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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            MetaFieldsSchema::applyContent($table);
            MetaFieldsSchema::applyMedia($table);

            $table->unsignedBigInteger('experience')->default(0);

            $table->boolean('is_current')->default(false);

            $table->timestamp('regenerated_at')->default(now());
            $table->timestamp('next_action_at')->default(now()->addSeconds(10));
            $table->timestamp('activity_at')->default(now());

            $table->json('inventory')->nullable();
            $table->json('equipment')->nullable();
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
        Schema::dropIfExists('characters');
    }
};

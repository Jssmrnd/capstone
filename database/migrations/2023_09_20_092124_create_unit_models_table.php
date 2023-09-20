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
        Schema::create('unit_models', function (Blueprint $table) {
            $table->id();
            $table->string("model_name")->nullable();
            $table->string("image_file")->nullable();
            $table->json("colors")->nullable();
            $table->string("price")->nullable();
            $table->string("body_type")->nullable();

            $table->decimal("dry_weight")->nullable();
            $table->integer("length_mm")->nullable();
            $table->integer("width_mm")->nullable();
            $table->integer("height_mm")->nullable();
            $table->integer("wheelbase_mm")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_models');
    }
};

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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('unit_branch')->nullable();
            $table->string('unit_model')->unique();
            $table->string('unit_color')->nullable();
            $table->integer('unit_quantity')->default(0);
            $table->string('unit_type')->nullable();
            $table->string('unit_srp')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};

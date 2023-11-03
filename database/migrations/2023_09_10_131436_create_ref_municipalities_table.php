<?php

use App\Models\RefMunicipality;
use App\Models\RefProvince;
use App\Models\RefRegion;
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
        Schema::create('ref_municipalities', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->string('psgcCode')->nullable();
            $table->string('citymunDesc')->nullable();
            $table->string('regDesc')->nullable();
            $table->string('provCode')->nullable();
            $table->string('citymunCode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_municipalities');
    }
};

<?php

use App\Models\RefBarangay;
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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regCode')->nullable();
            $table->foreignId('provCode')->nullable();
            $table->foreignId('citymunCode')->nullable();
            $table->foreignId('brgyDesc')->nullable();
            $table->string('branch_street')->nullable();
            $table->string('branch_building_number')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};

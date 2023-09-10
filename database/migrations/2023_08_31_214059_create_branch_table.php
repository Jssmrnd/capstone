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
            $table->foreignIdFor(RefRegion::class)->nullable();
            $table->foreignIdFor(RefProvince::class)->nullable();
            $table->foreignIdFor(RefMunicipality::class)->nullable();
            $table->foreignIdFor(RefBarangay::class)->nullable();
            $table->string('branch_address')->nullable();
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

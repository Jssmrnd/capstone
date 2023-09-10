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
            $table->id();
            $table->string('municipality_name');
            $table->foreignIdFor(RefRegion::class);
            $table->foreignIdFor(RefProvince::class);
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

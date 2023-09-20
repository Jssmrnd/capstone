<?php

use App\Models\Branch;
use App\Models\UnitModel;
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

            $table->foreignIdFor(Branch::class);
            $table->foreignIdFor(UnitModel::class);

            $table->string('engine_number')->unique();
            $table->string('frame_number')->unique();
            
            $table->integer('unit_quantity')->default(0);
            $table->string('status');
            $table->string('notes')->nullable();
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

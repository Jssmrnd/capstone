<?php

use App\Models\Branch;
use App\Models\CustomerApplication;
use App\Models\UnitModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->foreignIdFor(Branch::class)->nullable();
            $table->foreignIdFor(UnitModel::class);
            $table->string('chasis_number')
                    ->unique();
            $table->foreignIdFor(CustomerApplication::class)
                    ->nullable();
            $table->enum('status',['depo', 'repo', 'brand-new']);
            $table->string('notes')
                    ->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('units');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};

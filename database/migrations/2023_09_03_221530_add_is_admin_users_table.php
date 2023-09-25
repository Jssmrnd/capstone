<?php

use App\Models\Branch;
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
        Schema::table('users', function (Blueprint $table) {
            $table->string("gender");
            $table->date("birthday")
                    ->nullable()
                    ->after("gender");
            $table->string("contact_number")
                    ->after("gender");
            $table->boolean('is_admin')
                    ->default(true)->after("id");
            $table->foreignIdFor(Branch::class)
                    ->nullable()
                    ->constrained()
                    ->onUpdate('cascade')
                    ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('birthday');
            $table->dropColumn('contact_number');
            $table->dropColumn('is_admin');
            $table->dropForeignIdFor(Branch::class);
        });
    }
};

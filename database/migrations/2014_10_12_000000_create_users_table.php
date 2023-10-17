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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->from(1000000);
            $table->string("name");
            $table->string("password");
            $table->foreignIdFor(Branch::class)->nullable()->onDelete('set null');
            $table->timestamp('email_verified_at')->nullable();
            $table->string("email")->unique();
            $table->string("gender");
            $table->date("birthday")->nullable();
            $table->string("contact_number");
            $table->boolean('is_admin')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

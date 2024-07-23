<?php

use App\Models\User;
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
        Schema::create(User::TABLE_NAME, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string(User::NAME);
            $table->string(User::EMAIL)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string(User::PASSWORD);
            $table->enum(User::ROLE, ['user', 'admin'])->default("user");
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

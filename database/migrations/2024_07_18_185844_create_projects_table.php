<?php

use App\Models\Project;
use App\Models\Task;
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
        Schema::create(Project::TABLE_NAME, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string(Project::NAME);
            $table->string(Project::USER);
            $table->timestamps();

            $table->foreign(Project::USER)->references('id')->on(User::TABLE_NAME)->cascadeOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Project::TABLE_NAME);
    }
};

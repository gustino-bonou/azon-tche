<?php

use App\ENUM\TaskPriorityEnum;
use App\ENUM\TaskStatusEnum;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Task::TABLE_NAME, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string(Task::TITLE);
            $table->string(Task::DESCRIPTION)->nullable();
            $table->dateTime(Task::DEADLINE)->nullable();
            $table->string(Task::USER);
            $table->string(Task::PROJECT);
            $table->enum(Task::STATUS, [TaskStatusEnum::PENDING->value, TaskStatusEnum::IN_PROGRESS->value, TaskStatusEnum::ENDED->value])->default(TaskStatusEnum::PENDING->value);
            $table->enum(Task::PRIORITY, [TaskPriorityEnum::HEIGHT->value, TaskPriorityEnum::MEDIUM->value, TaskPriorityEnum::LOW->value])->default(TaskPriorityEnum::MEDIUM->value);
            $table->string(Task::DONE_BY)->nullable();
            $table->dateTime(Task::ASSIGN_AT)->nullable();
            $table->timestamps();

            $table->foreign(Task::DONE_BY)->references('id')->on(User::TABLE_NAME)->cascadeOnDelete();
            $table->foreign(Task::USER)->references('id')->on(User::TABLE_NAME)->cascadeOnDelete();
            $table->foreign(Task::PROJECT)->references('id')->on(Project::TABLE_NAME)->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Task::TABLE_NAME);
    }
};

<?php

namespace App\Http\Requests;

use App\ENUM\TaskPriorityEnum;
use App\ENUM\TaskStatusEnum;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $heightTask = TaskPriorityEnum::HEIGHT->value;
        $mediumTask = TaskPriorityEnum::MEDIUM->value;
        $lowTask = TaskPriorityEnum::LOW->value;
        $projectTable = Project::TABLE_NAME;

        $pendingStatus = TaskStatusEnum::PENDING->value;
        $inProgressStatus = TaskStatusEnum::IN_PROGRESS->value;
        $endedStatus = TaskStatusEnum::ENDED->value;
        return [
            Task::TITLE => ["required", "string"],
            Task::DESCRIPTION => ["nullable", "string"],
            Task::PRIORITY => ["required", "string", "in:$heightTask,$mediumTask,$lowTask"],
            Task::DEADLINE => ["nullable", "date"],
            Task::STATUS => ["required", "string", "in:$pendingStatus,$inProgressStatus,$endedStatus"],
            Task::PROJECT => ["required", "string", "exists:$projectTable,id"],
        ];
    }
}

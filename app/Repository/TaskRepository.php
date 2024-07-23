<?php

namespace App\Repository;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskRepository
{
    public function store(array $data): Task
    {
        return Task::create($data);
    }

    public function getTask($taskId): Task
    {
        return Task::findOrFail($taskId);
    }
    public function update(array $data, $taskId): Task
    {
        $task = Task::findOrFail($taskId);
        $task->update($data);
        return $this->getTask($taskId);
    }

}

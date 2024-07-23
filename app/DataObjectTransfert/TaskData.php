<?php

namespace App\DataObjectTransfert;

use App\Models\Task;
use DateTime;

class TaskData
{
    public function __construct(
        private readonly string $title,
        private readonly ?string $description,
        private readonly string $priority,
        private readonly string $status,
        private readonly ?DateTime $deadline,
        private readonly string $user,
        private readonly string $project,

    ) {
    }

    public function toArray()
    {
        return [
            Task::TITLE => $this->title,
            Task::DESCRIPTION => $this->description,
            Task::STATUS => $this->status,
            Task::PRIORITY => $this->priority,
            Task::DEADLINE => $this->deadline,
            Task::USER => $this->user,
            Task::PROJECT => $this->project,
        ];
    }
}

<?php

namespace App\DataObjectTransfert;
use App\Models\Project;

class ProjectData
{
    public function __construct(
        private readonly string $name,
        private readonly string $user,

    ) {
    }

    public function toArray()
    {
        return [
            Project::NAME => $this->name,
            Project::USER => $this->user,
        ];
    }
}

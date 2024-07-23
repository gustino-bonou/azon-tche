<?php

namespace App\Repository;

use App\Models\Project;
use App\Models\User;

class ProjectRepository
{
    public function store(array $data): Project
    {
        return Project::create($data);
    }

    public function getProject($userId): Project
    {
        return Project::findOrFail($userId);
    }
    public function update(array $data, $projectId): Project
    {
        $project = Project::findOrFail($projectId);
        $project->update($data);
        return $this->getProject($projectId);
    }

}

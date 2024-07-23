<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\User\UserResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            Task::TITLE => $this->{Task::TITLE},
            Task::DESCRIPTION => $this->{Task::DESCRIPTION},
            Task::DEADLINE => $this->{Task::DEADLINE},
            Task::STATUS => $this->{Task::STATUS},
            Task::PRIORITY => $this->{Task::PRIORITY},
            'author' => UserResource::make($this->whenLoaded("user")),
            'doneBy' => UserResource::make($this->whenLoaded("doneBy")),
        ];
    }
}

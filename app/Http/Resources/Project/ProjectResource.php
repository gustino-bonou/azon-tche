<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\User\UserResource;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name' => $this->{Project::NAME},
            'user_id' => $this->{Project::USER},
            'user' => UserResource::make($this->whenLoaded("user")),
        ];
    }
}

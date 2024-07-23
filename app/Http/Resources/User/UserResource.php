<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Project\ProjectResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->{User::NAME},
            'email' => $this->{User::EMAIL},
            'projects' => ProjectResource::collection($this->whenAppended("projects")),
        ];
    }
}

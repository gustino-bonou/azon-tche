<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\Project\ProjectResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectCollection extends ResourceCollection
{
    public $collects = ProjectResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray($request)
    {
        return [

            'data' => $this->collection,
            'success' => true,
            'error' => false
        ];
    }
}

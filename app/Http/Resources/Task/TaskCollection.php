<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Task\TaskResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public $collects = TaskResource::class;
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

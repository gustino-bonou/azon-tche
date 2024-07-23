<?php

namespace App\Http\Response;

use Illuminate\Contracts\Support\Responsable;

class CollectionResponse implements Responsable
{
    public function __construct(
        private $data,
        private $status = 200,
        array $headers = [],
        int $options = 0
    ) {
    }

    public function toResponse($request)
    {
        return response()->json(
            $this->data,
            status: $this->status,
            headers: ['Content-Type' => 'application/json'],
            options: 0
        );
    }

    public function getData()
    {
        return $this->data;
    }

    public function getStatusCode()
    {
        return $this->status;
    }
}

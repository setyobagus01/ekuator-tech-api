<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResource extends JsonResource
{
    private $status;
    private $code;
    private $message;

    public function __construct($status, $code, $message, $resource)
    {
        parent::__construct($resource);
        $this->status = $status;
        $this->code = $code;
        $this->message = $message;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->resource
        ];
    }
}

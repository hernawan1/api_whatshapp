<?php

namespace App\Http\Resources\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $data             = parent::toArray($request);
        $data['token']    = $this->when($this->token, $this->token);
        $data['password'] = $this->when($this->unhashed_password, $this->unhashed_password);

        return $data;
    }
}

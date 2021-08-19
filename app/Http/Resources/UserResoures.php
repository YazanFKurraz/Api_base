<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResoures extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'full_name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'token' => $this->token,
        ];
    }
}

<?php

namespace App\Http\Resources;

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
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "Date"=> $this->created_at->format("Y-M-d H:i:s"),//format("Year-Month-Day Hours-")
            "profile"=>new ProfileResource($this->whenLoaded('profile')),
        ];
    }
}

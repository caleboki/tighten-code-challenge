<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ObservationResource extends JsonResource
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
            'capybara_id' => $this->capybara_id,
            'date' => $this->date,
            'city' => $this->city,
            'hat' => $this->hat,
            'capybara' => new CapybaraResource($this->whenLoaded('capybara')),
        ];
    }
}

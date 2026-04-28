<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'client_custom_id' => $this->client_custom_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'dob' => $this->dob?->format('m/d/Y'),
            'phone' => $this->phone,
            'region' => $this->region,
            'care_plan' => $this->care_plan,
            'agent' => $this->agent ? $this->agent->name : 'Unassigned',
            'status' => $this->status,
            'created_at' => $this->created_at->format('m/d/Y H:i'),
        ];
    }
}

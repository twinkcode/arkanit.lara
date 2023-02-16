<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayoutsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->name,
            'details' => $this->details,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'status' => $this->status,

        ];
//        return parent::toArray($request);
    }
}

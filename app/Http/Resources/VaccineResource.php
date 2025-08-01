<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VaccineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return[
            'id' => $this->id,
            'Vaccine_name' => $this->name,
            'cat_id' => $this->cat_id,
            'period' => $this->period,
        ];
    }
}

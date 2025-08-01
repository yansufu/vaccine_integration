<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChildResource extends JsonResource
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
            'id' => $this->childID,
            'parent_id' => $this->parent_id,
            'name' => $this->name,
            'date_of_birth' => $this->date_of_birth,
            'NIK' => $this->NIK,
            'weight' => $this->weight,
            'height' => $this->height,
            'medical_history' => $this->medical_history,
            'allergy' => $this->allergy,
            'org_id' => $this->org_id,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CatalogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'catalog_id' => $this->id,
            'org_id' => $this->org_id,
            'organization' => [
                'id' => $this->organization->id,
                'name' => $this->organization->org_name,
            ],
            'cat_id' => $this->cat_id,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->category,
            ],
            'price' => $this->price,
            'vaccination_date' => $this->vaccination_date,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}

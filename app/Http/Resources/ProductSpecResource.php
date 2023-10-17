<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\SpecValueResource;
use App\Models\SpecValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSpecResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        static::withoutWrapping();
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'category' => $this->subCategory?->sub_name,
            'specs' => $this->whenLoaded('specs', SpecValueResource::collection($this->specs)),
        ];
    }
}

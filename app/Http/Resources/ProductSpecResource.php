<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\SpecValueResource;
use App\Models\SpecValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Log\Logger;

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
        $specs = [];
        foreach ($this->specs as $spec) {
            // array_push($specs[$spec->spec_name->specs_name], $spec->spec_value);
            // Logger($spec->spec_name);
            // dd($spec);
            $specs[$spec->specName?->specs_name][] = $spec->spec_value;
        }
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'category' => $this->subCategory?->sub_name,
            'specs' => $this->whenLoaded('specs', SpecValueResource::collection($this->specs, $specs)),
        ];
    }
}

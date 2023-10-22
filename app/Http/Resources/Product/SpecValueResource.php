<?php

namespace App\Http\Resources\Product;

use App\Models\SpecValuePivot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecValueResource extends JsonResource
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
            'id' => $this->code,
            'spec_name' => $this->specs_name,
            'values' => $this->whenPivotLoadedAs('spec_values', 'spec_value_intermediary', function () {
                return $this->spec_values->spec_value;
            }),
        ];
    }
}

// $this->whenPivotLoaded(new SpecValuePivot, function () {
//     return $this->spec_values->spec_value;
// })
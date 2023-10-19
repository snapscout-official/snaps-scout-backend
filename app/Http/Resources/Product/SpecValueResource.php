<?php

namespace App\Http\Resources\Product;

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
            'values' => $this->whenLoaded('values', function () {
                return $this->values->map(function ($value) {
                    return [
                        'value' => $value->spec_value
                    ];
                });
            })
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSpecValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'product';
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'sub_code' => $this->sub_code,
            'third_code' => $this->third_code,
            'description' => $this->description,
            'specs' => $this->whenLoaded('specs', function () {
                return $this->specs->map(function ($spec) {
                    return [
                        'code' => $spec->code,
                        'spec_name' => $spec->specs_name,
                        'value' => $spec->value->map(function ($specValue) {
                            return [
                                'id' => $specValue->id,
                                'spec_value' => $specValue->spec_value,
                            ];
                        })
                    ];
                });
            })
        ];
    }
}

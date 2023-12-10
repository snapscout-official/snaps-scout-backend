<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'product';
    public $preserveKeys = true;
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'third_name' => $this->when($this->thirdCategory, function () {
                return $this->thirdCategory->third_name;
            }),
            'sub_name' => $this->subCategory->sub_name,
            'specs' => $this->specs
            
        ];
    }
}

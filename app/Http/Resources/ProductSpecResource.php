<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\SpecValueResource;
use App\Models\SpecValue;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Log\Logger;

class ProductSpecResource extends JsonResource
{
    private $productSpecs;
    public function __construct($resource, $productSpecs)
    {
        parent::__construct($resource);
        $this->productSpecs = $productSpecs;
    }
    public function toArray(Request $request): array
    {
        static::withoutWrapping();
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'description' => $this->description,
            'category' => $this->subCategory?->sub_name,
            'specs' => $this->productSpecs,
        ];
    }
}

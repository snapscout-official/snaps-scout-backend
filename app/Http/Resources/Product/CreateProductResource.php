<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreateProductResource extends JsonResource
{
    private $subCategory = null;
    private $thirdCategory = null;
    public function __construct($resource, $subCategory, $thirdCategory = null)
    {
        parent::__construct($resource);
        $this->subCategory = $subCategory;
        $this->thirdCategory = $thirdCategory;
    }
    public function toArray(Request $request): array
    {
        return [
            'message' => 'succesfully added the product',
            'product' => $this->resource,
            'subCategory' => $this->subCategory,
            'thirdCategory' => $this->thirdCategory
        ];
    }
}

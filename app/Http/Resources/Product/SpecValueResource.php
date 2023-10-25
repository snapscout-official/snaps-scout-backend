<?php

namespace App\Http\Resources\Product;

use App\Models\SpecValuePivot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpecValueResource extends JsonResource
{
    private $specs;
    public function __construct($resource, $specs)
    {
        parent::__construct($resource);
        $this->specs = $specs;
    }
    public function toArray(Request $request): array
    {
        static::withoutWrapping();

        return [
            'id' => $this->code,
            'spec_name' => $this->specName->specs_name,
            // 'values' => $this->specs[$this->specName->specs_name],
        ];
    }
}

// $this->whenPivotLoaded(new SpecValuePivot, function () {
//     return $this->spec_values->spec_value;
// })
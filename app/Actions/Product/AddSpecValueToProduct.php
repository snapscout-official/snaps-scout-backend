<?php

namespace App\Actions\Product;

use App\Models\Spec;
use App\Models\Product;
use App\Http\Requests\AddSpecRequest;
use App\Models\SpecValue;

class AddSpecValueToProduct
{

    public function handle(Product $product, AddSpecRequest $request)
    {
        //created the spec if it does not exist else just return the spec instance
        $spec = Spec::firstOrCreate([
            'specs_name' => $request->specName,
        ]);
        //
        $specValueArray = [];
        //create the spec value 
        foreach($request->specValues as $key => $specVal)
        {
            $value = SpecValue::firstOrCreate([
                'spec_value' => $specVal
            ]);
            $specValueArray[] = $value->id;
        }
        $product->specs()->syncWithoutDetaching([$spec->code]);
        $spec->value()->syncWithOutDetaching([$specValueArray]);
    }
}
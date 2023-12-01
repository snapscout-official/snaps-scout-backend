<?php

namespace App\Actions\Product;

use App\Exceptions\ProductException;
use App\Models\Spec;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddSpecRequest;
use App\Models\SpecValue;
use Lorisleiva\Actions\Concerns\AsAction;

class AddSpecValueToProduct
{
    use AsAction;
    public function handle(Product $product, AddSpecRequest $request)
    {
        $data = DB::transaction(function () use ($product, $request) {
            $spec = Spec::firstOrCreate([
                'specs_name' => $request->specName,
            ]);

            //if creation fails throw an exception learn how to throw a custom exception
            if (empty($spec)) {
                throw new ProductException("error adding spec value on spec {$request->specName}");
            }
            $arrId = [];
            foreach ($request->specValues as $value) {
                //if the currently to be inserted value is already in the table then skip and proceed to the next value
                $arrId[] = SpecValue::firstOrCreate([
                    'spec_value' => $value,
                ])->id;
            }
            $spec->values()->syncWithoutDetaching($arrId);
            //attach to intermediate the spec and values with a desired product 
            DB::commit();
            $spec->refresh();
            $productWithSpecs = GetSpecOfProduct::loadProductSpecs($spec, $product);
            
            return ['productWithSpecs' => $productWithSpecs];
        });
        //extract the associative array
        extract($data);
        return empty($productWithSpecs) ? response()->json([
            'error' => 'error adding spec and specs value',
        ], 400) : response()->json([
            'message' => "spec and values successfully added to product {$productWithSpecs->product_name}",
            'data' => $productWithSpecs
        ], 201);
    }
}

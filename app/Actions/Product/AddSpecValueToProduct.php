<?php

namespace App\Actions\Product;

use App\Exceptions\ProductException;
use App\Exceptions\TestException;
use App\Models\Spec;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddSpecRequest;
use App\Http\Resources\ProductSpecResource;
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
            $existingProductValuesName = $spec->values()->wherePivot('product_id', $product->product_id)
                ->get()
                ->map(function ($value) {
                    return $value->spec_value;
                })->toArray();
            // dd($existingProductValuesName);
            //store each id of the specValue into an array
            $arrId = [];
            foreach ($request->specValues as $value) {
                if (in_array($value, $existingProductValuesName)) {
                    continue;
                }
                $arrId[] = SpecValue::firstOrCreate([
                    'spec_value' => $value,
                ])->id;
            }
            //attach to intermediate the spec and values with a desired product 
            $spec->values()->attach($arrId, ['product_id' => $product->product_id]);
            DB::commit();
            $spec->refresh();
            $productSpecs = GetSpecOfProduct::loadProductSpecs($spec, $product);

            return ['product' => $product, 'productSpecs' => $productSpecs];
        });

        extract($data);
        return empty($product) ? response()->json([
            'error' => 'error adding spec and specs value',
        ], 400) : response()->json(new ProductSpecResource($product, $productSpecs), 201);
    }
}

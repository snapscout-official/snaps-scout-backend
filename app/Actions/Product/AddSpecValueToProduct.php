<?php

namespace App\Actions\Product;

use App\Models\Spec;
use App\Models\Product;
use App\Models\SpecValue;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddSpecRequest;
use App\Http\Resources\ProductSpecResource;
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

            if (empty($spec)) {
                //throw an exception learn how to throw a custom exception
            }

            $specValueArray = [];
            foreach ($request->specValues as $key => $value) {
                $result = SpecValue::firstOrCreate([
                    'spec_value' => $value
                ]);
                $specValueArray[] = $result->id;
            }
            $product->specs()->syncWithoutDetaching([$spec->code]);
            $spec->values()->syncWithOutDetaching($specValueArray);
            $product = Product::with('specs.values')->find($product->product_id);
            return ['spec' => $spec, 'product' => $product];
        });
        extract($data);
        return empty($product) ? response()->json([
            'error' => 'error adding spec and specs value',
        ]) : response()->json(new ProductSpecResource($product), 201);
    }
}

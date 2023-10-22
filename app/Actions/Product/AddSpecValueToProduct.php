<?php

namespace App\Actions\Product;

use App\Models\Spec;
use App\Models\Product;
use App\Models\SpecValue;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddSpecRequest;
use App\Http\Resources\ProductSpecResource;
use Illuminate\Log\Logger;
use Lorisleiva\Actions\Concerns\AsAction;

class AddSpecValueToProduct
{
    use AsAction;
    public function handle(Product $product, AddSpecRequest $request)
    {

        $product = DB::transaction(function () use ($product, $request) {
            $spec = Spec::firstOrCreate([
                'specs_name' => $request->specName,
            ]);

            //if creation fails throw an exception learn how to throw a custom exception
            if (empty($spec)) {
            }
            //attach the specName and  each specValues to the intermediary table
            foreach ($request->specValues as $value) {
                $specValueId = SpecValue::firstOrCreate([
                    'spec_value' => $value
                ])->id;

                $product->specs()->attach($spec->code, ['spec_value_id' => $specValueId]);
            }
            DB::commit();
            //rehydrate the existing model with fresh data and all of its loaded relationship
            // $product->refresh();
            $product = Product::with('specs')->find($product->product_id);
            return $product;
        });
        Logger($product);
        return empty($product) ? response()->json([
            'error' => 'error adding spec and specs value',
        ]) : response()->json(new ProductSpecResource($product), 201);
    }
}

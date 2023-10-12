<?php

namespace App\Actions\Product;

use App\Models\Spec;
use App\Models\Product;
use App\Models\SpecValue;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddSpecRequest;
use App\Http\Resources\ProductSpecValueResource;
use Illuminate\Log\Logger;
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

            $specValueArray = [];
            foreach ($request->specValues as $key => $specVal) {
                $value = SpecValue::firstOrCreate([
                    'spec_value' => $specVal
                ]);
                $specValueArray[] = $value->id;
            }
            Logger($specValueArray);
            $product->specs()->syncWithoutDetaching([$spec->code]);
            $spec->value()->syncWithOutDetaching($specValueArray);
            $product = Product::with('specs.value')->find($product->product_id);
            return ['spec' => $spec, 'product' => $product];
        });
        extract($data);

        return (new ProductSpecValueResource($product))
            ->additional(['message' => "successfully added spec {$spec->specs_name}"]);
    }
}

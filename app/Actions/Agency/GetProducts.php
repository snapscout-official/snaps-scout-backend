<?php

namespace App\Actions\Agency;

use App\Http\Requests\Agency\GetProductsRequest;
use App\Models\AgencyCategories;
use App\Models\AgencyProduct;   
use Lorisleiva\Actions\Concerns\AsAction;

class GetProducts
{
    use AsAction;
    public function handle(GetProductsRequest $request)
    {
        $categories = AgencyCategories::where('document_id',$request->document_id)->get();
        // dd($categories);
        $products = [];
        foreach ($categories->data as $data) {
            if($data['parentCategoryName'] === $request->parentCategoryName)
            {
                $products[] = AgencyProduct::create([
                'parentCategoryName' => $data['parentCategoryName'],
                'products' => json_encode($data['products']),
                'productNumber' => $data['productNumber'],
                'totalQuantity' => $data['totalQuantity'],
            ]);
            }
        }
        return $products;
        // return response("Nothing",200);
    }
}
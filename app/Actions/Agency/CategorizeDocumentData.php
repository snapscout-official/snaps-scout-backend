<?php

namespace App\Actions\Agency;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Imports\CategoryTestImport;
use Lorisleiva\Actions\Concerns\AsAction;
use App\Http\Requests\Agency\CategorizeDocumentRequest;
use Illuminate\Support\Facades\Storage;

class CategorizeDocumentData
{
    use AsAction;
    public function handle(CategorizeDocumentRequest $request)
    {
        //document name should be queried from the local disk and get the appropriate document name using agencyId and original document name
        [$generalDesc, $unitMeasure, $quantity] = $request->getHeadings();
        $categoryTestimport = new CategoryTestImport();
        $categoryTestimport->onlySheets('sheet2');
        //transform in to an associative with a column/value pair
        $importArray =  $categoryTestimport->toArray(Storage::path($request->documentName))[1];
        //sanitize or filter the import array closing and opening parenthesis
        $categorized = [];
        $code = 1;
        foreach ($importArray as $row) {
            //replace parenthesis with commas in order for the explode 
            $productName = Str::replace(['(', ')'], ',', $row[$generalDesc]);
            //modify to lower case each word and then upper case word after
            $productName = Str::lower(explode(',', $productName)[0]);
            $productName  = ucfirst($productName);
            //gets the product from the product table of our admin 

            //on each product retrieved from the imported array, we query it to the database to check if it has a match
            //eager load also the retrieved product
            $matchedProduct = Product::where('product_name', $productName)->with('subCategory.parentCategory')
                ->first();

            //if is null or it means that the productName does not exist on the database meaning it has no category associated
            //add it to the others category 
            if (is_null($matchedProduct)) {
                if (!isset($categorized['others']['quantity'])) {
                    $categorized['others']['quantity'] = $row['quantitysize'];
                    $categorized['others']['products'][] = [$code, $row[$generalDesc], $row[$unitMeasure], $row[$quantity]];
                    $categorized['others']['totalProducts'] = count($categorized['others']['products']);
                    $code++;
                    continue;
                }
                $categorized['others']['products'][] = [$code, $row[$generalDesc], $row[$unitMeasure], $row[$quantity]];
                $categorized['others']['totalProducts'] = count($categorized['others']['products']);
                $code++;
                $categorized['others']['quantity'] += $row['quantitysize'];
                continue;
            }
            $parentName = $matchedProduct->subCategory->parentCategory->parent_name;
            //if it passes all of this conditional then it means that we can add it and map it to the parentCategory key/value pair
            // categoryName => ['products' => [array of products], 'quantity => realNumber ]
            if (!isset($categorized[$parentName]['quantity'])) {
                $categorized[$parentName]['quantity'] = $row['quantitysize'];
                $categorized[$parentName]['products'][] = [$code, $row[$generalDesc], $row[$unitMeasure], $row[$quantity]];
                $categorized[$parentName]['totalProducts'] = count($categorized[$parentName]['products']);
                $code++;
                continue;
            }
            $categorized[$parentName]['products'][] = [$code, $row[$generalDesc], $row[$unitMeasure], $row[$quantity]];
            $categorized[$parentName]['totalProducts'] = count($categorized[$parentName]['products']);
            $code++;

            $categorized[$parentName]['quantity'] += $row['quantitysize'];
        }
        $data = [];
        $overallTotalProducts = 0;
        foreach ($categorized as $category => $value) {
            $overallTotalProducts += $value['totalProducts'];

            $data[] = ['parentCategoryName' => $category, 'products' => $value['products'], 'productNumber' => $value['totalProducts'], 'isComplete' => false, 'totalQuantity' => $value['quantity']];
        }
        return [$data, $overallTotalProducts];
    }
}

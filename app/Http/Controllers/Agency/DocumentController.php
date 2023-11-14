<?php

namespace App\Http\Controllers\Agency;

use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Imports\SecondSheetImport;
use App\Imports\CategoryTestImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\HeadingRowImport;
use App\Http\Requests\Agency\AgencyDocumentRequest;

class DocumentController extends Controller
{
    public function upload(AgencyDocumentRequest $request)
    {
        if (!$request->fileIsValid()) {
            return response()->json([
                'error' => 'file format is invalid'
            ], 422);
        }
        [$generalDesc, $unitMeasure, $quantity] = $request->headings;
        $categoryTestimport = new CategoryTestImport();
        $categoryTestimport->onlySheets('sheet2');
        //transform in to an associative with a column/value pair
        $importArray =  $categoryTestimport->toArray($request->file('document'))[1];
        //sanitize or filter the import array closing and opening parenthesis
        $products = Product::with('subCategory.parentCategory')->get();
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
                continue;
            }
            $categorized[$parentName]['products'][] = [$code, $row[$generalDesc], $row[$unitMeasure], $row[$quantity]];
            $categorized[$parentName]['totalProducts'] = count($categorized[$parentName]['products']);
            $code++;

            $categorized[$parentName]['quantity'] += $row['quantitysize'];
        }
        return response()->json([
            'message' => 'sucessfully categorizing data',
            'data' => $categorized
        ], 201);
    }
}

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
        //gets the headings of the csv file
        $headings = (new HeadingRowImport(SecondSheetImport::HEADER))->toArray($request->file('document'))[1][0];
        //headings is an array so destructure its value with corresponding header Name
        [$generalDesc, $unitMeasure, $quantity] = $headings;
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

            $first = Arr::first($products, function ($value, int $key) use ($productName) {
                return $value->product_name === $productName;
            });


            //if is null or it means that the productName does not exist on the database meaning it has no category associated
            //add it to the others category 
            if (is_null($first)) {
                $categorized['others']['products'][] = [$code, $row[$generalDesc], $row[$unitMeasure], $row[$quantity]];
                $code++;
                if (!isset($categorized['others']['quantity'])) {
                    $categorized['others']['quantity'] = $row['quantitysize'];
                    continue;
                }
                $categorized['others']['quantity'] += $row['quantitysize'];
                continue;
            }
            $parentName = $first->subCategory->parentCategory->parent_name;
            //if it passes all of this conditional then it means that we can add it and map it to the parentCategory key/value pair
            // categoryName => ['products' => [array of products], 'quantity => realNumber ]
            $categorized[$parentName]['products'][] = [$code, $row[$generalDesc], $row[$unitMeasure], $row[$quantity]];
            $code++;
            if (!isset($categorized[$parentName]['quantity'])) {
                $categorized[$parentName]['quantity'] = $row['quantitysize'];
                continue;
            }
            $categorized[$parentName]['quantity'] += $row['quantitysize'];
        }
    }
}

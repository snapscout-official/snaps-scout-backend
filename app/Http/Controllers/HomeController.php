<?php

namespace App\Http\Controllers;

use App\Imports\TestImport;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Imports\SecondSheetImport;
use App\Imports\CategoryTestImport;
use App\Models\Product;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {

        //gets the headings of the csv file
        $headings = (new HeadingRowImport(SecondSheetImport::HEADER))->toArray(storage_path('app/public/SnapScout(2).xlsx'))[1][0];
        //headings is an array so destructure its value with corresponding header Name
        [$generalDesc, $unitMeasure, $quantity] = $headings;
        $categoryTestimport = new CategoryTestImport();
        $categoryTestimport->onlySheets('sheet2');
        //transform in to an associative with a column/value pair
        $importArray =  $categoryTestimport->toArray(storage_path('app/public/SnapScout(2).xlsx'))[1];
        //sanitize or filter the import array closing and opening parenthesis
        $products = Product::with('subCategory.parentCategory')->get();
        $categorized = [];
        $quantity = [];
        foreach ($importArray as $row) {
            $productName = Str::replace(['(', ')', ' '], ',', $row[$generalDesc]);
            $productName = Str::lower(explode(',', $productName)[0]);
            $first = Arr::first($products, function ($value, int $key) use ($productName) {
                return $value->product_name === $productName;
            });
            //if is null or it means that the productName does not exist on the database meaning it has no category associated
            //add it to the others category 
            if (is_null($first)) {
                $categorized['others'][] = $productName;
                continue;
            }
            //if the key already exist in the array of the categorized and if it is already in the array
            if (array_key_exists($first->subCategory->parentCategory->parent_name, $categorized) && in_array($productName, $categorized[$first->subCategory->parentCategory->parent_name])) {
                continue;
            }
            //if it passes all of this conditional then it means that we can add it and map it to the parentCategory key/value pair
            // categoryName => ['products' => [array of products], 'quantity => realNumber ]
            $categorized[$first->subCategory->parentCategory->parent_name]['products'][] = $productName;
            if (!isset($categorized[$first->subCategory->parentCategory->parent_name]['quantity'])) {
                $categorized[$first->subCategory->parentCategory->parent_name]['quantity'] = $row['quantitysize'];
                continue;
            }
            $categorized[$first->subCategory->parentCategory->parent_name]['quantity'] += $row['quantitysize'];
        }
        return $categorized;
        // return URL::temporarySignedRoute('delete', now()->addMinutes(1), ['product' => 1, 'spec' => 2]);
    }
}

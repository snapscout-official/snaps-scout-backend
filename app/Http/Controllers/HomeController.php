<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
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
        $code = 1;
        foreach ($importArray as $row) {
            //replace parenthesis with commas in order for the explode 
            $productName = Str::replace(['(', ')', ' '], ',', $row[$generalDesc]);
            $productName = Str::lower(explode(',', $productName)[0]);
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

        // return $categorized;
        return Excel::download(new CategoryExport($categorized), 'category.xlsx');
        // return URL::temporarySignedRoute('delete', now()->addMinutes(1), ['product' => 1, 'spec' => 2]);
    }
}

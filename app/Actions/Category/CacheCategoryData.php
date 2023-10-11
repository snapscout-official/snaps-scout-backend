<?php

namespace App\Actions\Category;

use Illuminate\Support\Arr;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class CacheCategoryData
{
    use AsAction;
    public function handle()
    {
        return Cache::remember('categories', 600, function()
        {
            $data = ParentCategory::with('subCategories.thirdCategories')->get();
            $subCategories = [];  
            foreach($data as $key => $parentCategory)
            {
                $subCategories[$key] = Arr::flatten($parentCategory->subCategories);
            }
            return ['data' => $data, 'subCategories' => $subCategories];
        });
    }
}
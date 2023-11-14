<?php

namespace App\Actions\Category;

use Illuminate\Support\Arr;
use App\Models\ParentCategory;
use App\Models\SubCategory;
use App\Models\ThirdCategory;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

class CacheCategoryData
{
    use AsAction;
    public function handle()
    {
        return Cache::remember('categories', 600, function () {
            $parentCategories = ParentCategory::all();
            $subCategories = SubCategory::getSubCategoriesWithParent();
            $thirdCategories = ThirdCategory::returnThirdCategoryWithParentSub();
            return ['parentCategories' => $parentCategories, 'subCategories' => $subCategories, 'thirdCategories' => $thirdCategories];
        });
    }
}

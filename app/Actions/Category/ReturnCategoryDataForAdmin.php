<?php

namespace App\Actions\Category;

use App\Models\ParentCategory;
use Lorisleiva\Actions\Concerns\AsAction;

class ReturnCategoryDataForAdmin
{
    use AsAction;

    public function handle()
    {
        $data = CacheCategoryData::run();

        return response()->json([
            'parentCategories' => $data['parentCategories'],
            'subCategories' => $data['subCategories'],
            'thirdCategories' => $data['thirdCategories'],
        ], 200);
    }
}

<?php

namespace App\Actions\Category;

use Lorisleiva\Actions\Concerns\AsAction;

class ReturnCategoryDataForAdmin
{
    use AsAction;
    
    public function handle()
    {
        $data = CacheCategoryData::run();
        return response()->json([
            'categories' => $data['data'],
            'subCategories' => $data['subCategories'],
        ], 200);
    }
}
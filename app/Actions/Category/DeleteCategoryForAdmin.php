<?php

namespace App\Actions\Category;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Events\CategoryDeleted;
use Illuminate\Support\Facades\Cache;

class DeleteCategoryForAdmin
{
    use AsAction;

    public function handle(int $categoryId, string $categoryType)
    {
        //parses the passed string since it is a fully qualified classname
        $parsedCategory = explode('\\', $categoryType);
        $categoryName = end($parsedCategory);

        //deletes the category base on its type
        //update the cache manually change to
        if ($categoryType::destroy($categoryId)) {

            Cache::forget('categories');
            $data = CacheCategoryData::run();

            return response()->json([
                'message' => "{$categoryName} of id {$categoryId} successfully deleted",
                'parentCategories' => $data['parentCategories']
            ]);
        }
        return response()->json(
            [
                'error' => "{$categoryName} id {$categoryId} has error deleting"
            ]
        );
    }
}

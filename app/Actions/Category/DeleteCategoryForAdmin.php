<?php

namespace App\Actions\Category;

use App\Events\CategoryDeleted;
use Lorisleiva\Actions\Concerns\AsAction;

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
        if ($categoryType::destroy($categoryId))
        {

            event(new CategoryDeleted());
            $data = CacheCategoryData::run();

            return response()->json([
                'message' => "{$categoryName} of id {$categoryId} successfully deleted",
                'categories' => $data['data']
            ]);
        }
        return response()->json(
            [
                'error' => "{$categoryName} id {$categoryId} has error deleting"
            ]
        );
    }
}
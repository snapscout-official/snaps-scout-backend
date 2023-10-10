<?php

namespace App\Listeners;

use Illuminate\Support\Arr;
use App\Models\ParentCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCategoryCache
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Cache::forget('categories',);
        //query the database of the fresh data
        $categories = ParentCategory::with('subCategories.thirdCategories')->get();
        $subCategories = [];
        foreach($categories as $key => $parentCategory)
            {
                $subCategories[$key] = Arr::flatten($parentCategory->subCategories);
            }
        Cache::put('categories', ['data' => $categories, 'subCategories' => $subCategories]);
    }

}

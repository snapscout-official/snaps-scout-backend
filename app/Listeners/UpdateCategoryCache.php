<?php

namespace App\Listeners;

use App\Actions\Category\CacheCategoryData;
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
        Cache::forget('categories');
        CacheCategoryData::run();
    }
}

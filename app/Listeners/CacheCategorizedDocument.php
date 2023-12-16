<?php

namespace App\Listeners;

use App\Events\DocumentCategorized;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CacheCategorizedDocument
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }
    public function handle(DocumentCategorized $event): void
    {
        $documentId = $event->categorizedData['document_id'];
       //cache document data with a documentId + products key
        Cache::store('cache')->put("{$documentId}products", $event->categorizedData, 600);
    }
}

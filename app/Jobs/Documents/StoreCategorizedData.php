<?php

namespace App\Jobs\Documents;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\Models\CategorizedDocument;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class StoreCategorizedData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public $categorizedData, public $documentModel)
    {
    }


    public function handle(): void
    {
        DB::beginTransaction();
        $this->documentModel->categorizedDocument()->create($this->categorizedData);
        $this->documentModel->is_categorized = true;
        $this->documentModel->save();
        DB::commit();
    }
}
